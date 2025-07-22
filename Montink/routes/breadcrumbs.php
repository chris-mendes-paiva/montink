<?php

#PRODUTOS
Breadcrumbs::register('produtos', function ($breadcrumbs) {
    $breadcrumbs->push('Produtos', route('produtos'));
});
Breadcrumbs::register('create-produtos', function ($breadcrumbs) {
    $breadcrumbs->parent('produtos');
    $breadcrumbs->push('Cadastrar novo Produto', route('produtos.create'));
});
Breadcrumbs::register('edit-produtos', function ($breadcrumbs, $produtos) {
    $breadcrumbs->parent('produtos');
    $breadcrumbs->push('Editar Produto', route('produtos.edit', $produtos->id_produto));
});


#ESTOQUE
Breadcrumbs::register('estoque', function ($breadcrumbs) {
    $breadcrumbs->push('Estoques', route('estoque'));
});
Breadcrumbs::register('edit-estoque', function ($breadcrumbs, $estoque) {
    $breadcrumbs->parent('estoque');
    $breadcrumbs->push('Editar Estoque Produto', route('estoque.edit', $estoque->id_produto));
});

#CUPONS
Breadcrumbs::register('cupons', function ($breadcrumbs) {
    $breadcrumbs->push('Cupons', route('cupons'));
});
Breadcrumbs::register('create-cupons', function ($breadcrumbs) {
    $breadcrumbs->parent('cupons');
    $breadcrumbs->push('Cadastrar novo Cupom', route('cupons.create'));
});
Breadcrumbs::register('edit-cupons', function ($breadcrumbs, $cupons) {
    $breadcrumbs->parent('cupons');
    $breadcrumbs->push('Editar Cupom', route('cupons.edit', $cupons->id_cupom));
});

#PEDIDOS
Breadcrumbs::register('pedidos', function ($breadcrumbs) {
    $breadcrumbs->push('Pedidos', route('pedidos'));
});
Breadcrumbs::register('create-pedidos', function ($breadcrumbs) {
    $breadcrumbs->parent('pedidos');
    $breadcrumbs->push('Realizar novo Pedido', route('pedidos.create'));
});