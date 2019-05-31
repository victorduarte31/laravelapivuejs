<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreUpdateFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $category, $totalPage = 10;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->category->getResults($request->name);

        // O laravel por default trabalha no formato json, então o retorno vira nesse formato

        /*return $categories;  podemos utilizar nesse formato ou especificando no formato abaixo*/

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateFormRequest $request)
    {
        $category = $this->category->create($request->all());

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$category = $this->category->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateFormRequest $request, $id)
    {
        if (!$category = $this->category->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        $category->update($request->all());

        return response()->json($category, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$category = $this->category->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        $category->delete();
        return response()->json(['success' => true], 204);
    }

    public function products($id)
    {

        if (!$category = $this->category->find($id)) // busca a categoria por id
            return response()->json(['error' => 'Not Found'], 404);

        $products = $category->products()->paginate($this->totalPage); // busca os produtos atraves do seu relacionamento

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
    }

}
