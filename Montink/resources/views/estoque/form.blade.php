<div class="form-row">  
    <div class="form-group col-md-3">
        {!! Form::label('nome_produto', 'Nome Produto') !!}                                
        {!! Form::text('nome_produto', null, ['placeholder'=>'Nome', 'class' => 'form-control', 'disabled']) !!}   
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('descricao', 'Descrição') !!}                                
        {!! Form::text('descricao', null, ['placeholder'=>'Descrição', 'class' => 'form-control', 'disabled']) !!}   
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('preco', 'Preço') !!}                                
        {!! Form::number('preco', null, ['placeholder'=>'Preço', 'class' => 'form-control', 'disabled']) !!}   
    </div>
     <div class="form-group col-md-3">
        {!! Form::label('estoque', 'Estoque') !!}                                
        {!! Form::number('estoque', null, ['placeholder'=>'Estoque', 'class' => 'form-control']) !!}   
    </div>
</div>
