@extends('layouts.app')
@push('scripts')
    <script src="/js/i18n/defaults-pt_BR.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-select.min.js"></script>
@endpush
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <link rel="stylesheet" href="/css/bootstrap-select.min.css">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                                <h5 class="card-title">{!! Breadcrumbs::render('create-produtos') !!} </h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['url' => 'produtos/store', 'class' => 'ui form','files' => true]) !!}
                                @include('produtos.form')
                            {!! Form::submit('Cadastrar', ['class'=>'btn btn-primary']) !!}
                            {!! Form::close() !!}   
                        </div>
                    </div>
                </div> 
            </div>  
        </div>  
    </div>  
</div>  
@endsection
