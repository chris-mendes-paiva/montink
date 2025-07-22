@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Gerenciamento Interno</div>
                {{-- Pensei em definir tipo usuario, caso admin, gerencia produto, estoque e cupons --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="title m-b-md">
                </div>

                <div class="form-group col-md-12">                   
                    <a href="/produtos"><button id="produtos"  type="button" class="btn btn-primary" >Produtos</button></a>
                    <a href="/estoque"><button id="estoque"  type="button" class="btn btn-primary" >Estoques</button></a>
                    <a href="/cupons"><button id="cupons"  type="button" class="btn btn-primary" >Cupons</button></a>
                </div>
               
                </div>
            </div>

            <div class="card">
                <div class="card-header">Vendas</div>

                <div class="card-body">
                    {{-- Pensei em definir tipo usuario, caso comum, so pedidos e acompanhamento --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="title m-b-md">
                </div>

                <div class="form-group col-md-12">                                      
                    <a href="/pedidos"><button id="pedidos"  type="button" class="btn btn-success" >Realizar Pedido</button></a>
                </div>
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
