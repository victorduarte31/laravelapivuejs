<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreUpdateProductFormRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $product;
    private $totalPage = 10;
    private $path = 'products';

    public function __construct(Product $product)
    {
        $this->product = $product;

        /*
         * Definindo quais metodos estaram liberados para serem acessados sem o usuario estar logado
         */
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->product->getResult($request->all(), $this->totalPage);

        return response()->json($products, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductFormRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = Str::kebab($request->name); // ex: FooBar ira ser transformado em foo-bar
            $extension = $request->image->extension(); // pegar a extenção da imagem

            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile); // Guardar a imagem em um diretorio de nome products

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }

        $product = $this->product->create($data);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$product = $this->product->with('category')->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductFormRequest $request, $id)
    {

        // Verificando se encontrou o produto
        if (!$product = $this->product->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        $data = $request->only(['name', 'description', 'image']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($product->image) {
                if (Storage::exists("{$this->path}/{$product->image}")) {
                    Storage::delete("{$this->path}/{$product->image}");
                }
            }

            $name = Str::kebab($request->name); // ex: FooBar ira ser transformado em foo-bar
            $extension = $request->image->extension(); // pegar a extenção da imagem

            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile); // Guardar a imagem em um diretorio de nome products

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }

        $product->update($data);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$product = $this->product->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        if ($product->image) {
            if (Storage::exists("{$this->path}/{$product->image}")) {
                Storage::delete("{$this->path}/{$product->image}");
            }
        }

        $product->delete();

        return response()->json(['success' => 'Produto deletado com sucesso']);
    }
}
