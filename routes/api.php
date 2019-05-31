<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// TRABALHANDO COM VERSIONAMENTO DE API
Route::group([
    'prefix'        => 'v1', // prefixo
    'namespace'     => 'Api\v1', // diretorio onde se encontra os controllers
   /* 'middleware'    => 'auth:api' // 'auth:api' responsavel pela autenticação*/
], function () {
    Route::get('categories/{id}/products', 'CategoryController@products');
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('products', 'ProductController');
});

/**
 * ROTAS DE AUTENTICAÇÃO
 */
Route::post('auth', 'Auth\AuthApiController@authenticate'); // gerar token para autenticar
Route::post('auth-refresh', 'Auth\AuthApiController@refresh'); // atualizar token expirado
Route::get('me', 'Auth\AuthApiController@getAuthenticatedUser'); // devolver usuario logado atravez do token

