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
                <div class="card-header">
                        <h5 class="card-title">{!! Breadcrumbs::render('edit-estoque', $estoque) !!} </h5>
=                </div>
                <div class="card-body">
                    {!! Form::model($estoque, [
                        'method' => 'PUT',
                        'url' => route('estoque.update', $estoque->id_produto),
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}
                    @include('estoque.form')
                    {!! Form::submit('Alterar', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}   
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection