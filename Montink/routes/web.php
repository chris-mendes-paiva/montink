<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/montink', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Rotas Gerenciar Produtos
Route::prefix('produtos')->group(function () {
    Route::get('', 'ProdutosController@index')->name('produtos');
    Route::post('', 'ProdutosController@getProdutosData')->name('nome.ajax');  
    Route::post('busca/nome', 'ProdutosController@getNomeAjax')->name('busca.nome'); 
    Route::get('/create', ['as' => 'produtos.create', 'uses' => 'ProdutosController@create']);
    Route::post('store', ['as' => 'produtos.store', 'uses' => 'ProdutosController@store']);
    Route::delete('{id_produto}/destroy', ['as' => 'produtos.destroy', 'uses' => 'ProdutosController@destroy']);
    Route::get('{id_produto}/edit', ['as' => 'produtos.edit', 'uses' => 'ProdutosController@edit']);
    Route::put('{id_produto}/update', ['as' => 'produtos.update', 'uses' => 'ProdutosController@update']);
});
//Rotas Gerenciar Estoques
Route::prefix('estoque')->group(function () {
    Route::get('', 'EstoqueController@index')->name('estoque');
    Route::post('', 'EstoqueController@getEstoqueData')->name('nome.ajax');  
    Route::post('busca/nome', 'EstoqueController@getNomeAjax')->name('busca.nome'); 
    Route::delete('{id_produto}/destroy', ['as' => 'estoque.destroy', 'uses' => 'EstoqueController@destroy']);
    Route::get('{id_produto}/edit', ['as' => 'estoque.edit', 'uses' => 'EstoqueController@edit']);
    Route::put('{id_produto}/update', ['as' => 'estoque.update', 'uses' => 'EstoqueController@update']);
});
//Rotas Gerenciar Pedidos
Route::prefix('pedidos')->group(function () {
    Route::get('', 'PedidosController@index')->name('pedidos');
    Route::post('', 'PedidosController@getPedidosData')->name('nome.ajax');  
    Route::post('busca/nome', 'PedidosController@getNomeAjax')->name('busca.nome'); 
    Route::get('/create', ['as' => 'pedidos.create', 'uses' => 'PedidosController@create']);
    Route::post('store', ['as' => 'pedidos.store', 'uses' => 'PedidosController@store']);
    Route::delete('{id_pedido}/destroy', ['as' => 'pedidos.destroy', 'uses' => 'PedidosController@destroy']);
});


//Rotas Gerenciar Cupons
Route::prefix('cupons')->group(function () {
    Route::get('', 'CuponsController@index')->name('cupons');
    Route::post('', 'CuponsController@getCuponsData')->name('nome.ajax');  
    Route::post('busca/nome', 'CuponsController@getNomeAjax')->name('busca.nome'); 
    Route::get('/create', ['as' => 'cupons.create', 'uses' => 'CuponsController@create']);
    Route::post('store', ['as' => 'cupons.store', 'uses' => 'CuponsController@store']);
    Route::delete('{id_cupon}/destroy', ['as' => 'cupons.destroy', 'uses' => 'CuponsController@destroy']);
    Route::get('{id_cupon}/edit', ['as' => 'cupons.edit', 'uses' => 'CuponsController@edit']);
    Route::put('{id_cupon}/update', ['as' => 'cupons.update', 'uses' => 'CuponsController@update']);
});