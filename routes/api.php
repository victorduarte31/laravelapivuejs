<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// TRABALHANDO COM VERSIONAMENTO DE API
Route::group([
    'prefix' => 'v1', // prefixo
    'namespace' => 'Api\v1', // diretorio onde se encontra os controllers
    'middleware' => 'auth:api' // 'auth:api' responsavel pela autenticação
], function () {
    Route::get('categories/{id}/products', 'CategoryController@products');
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('products', 'ProductController');
});


Route::group([
    'namespace' => 'Auth\api', // diretorio onde se encontra os controllers
], function () {
    /**
     * ROTAS DE AUTENTICAÇÃO
     */
    Route::post('auth', 'AuthApiController@authenticate'); // gerar token para autenticar
    Route::post('auth-refresh', 'AuthApiController@refresh'); // atualizar token expirado
    Route::get('me', 'AuthApiController@getAuthenticatedUser'); // devolver usuario logado atravez do token

// Cadastrar novo usuario
    Route::post('register', 'ProfileApiController@register');

// Editar usuario
    Route::put('update', 'ProfileApiController@update');

});
