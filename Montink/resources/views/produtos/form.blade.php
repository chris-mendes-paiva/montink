<div class="form-row">  
    <div class="form-group col-md-4">
        {!! Form::label('nome_produto', 'Nome Produto') !!}                                
        {!! Form::text('nome_produto', null, ['placeholder'=>'Nome', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('descricao', 'Descrição') !!}                                
        {!! Form::text('descricao', null, ['placeholder'=>'Descrição', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('preco', 'Preço') !!}                                
        {!! Form::number('preco', null, ['placeholder'=>'Preço', 'class' => 'form-control']) !!}   
    </div>
</div>
