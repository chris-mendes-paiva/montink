<div class="form-row">  
    <div class="form-group col-md-4">
        {!! Form::label('codigo', 'Codigo') !!}                                
        {!! Form::text('codigo', null, ['placeholder'=>'Codigo', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('tipo_desconto', 'Tipo Desconto') !!}                                
        {!! Form::text('tipo_desconto', null, ['placeholder'=>'Tipo Desconto', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('valor_desconto', 'Valor Desconto') !!}                                
        {!! Form::number('valor_desconto', null, ['placeholder'=>'Valor Desconto', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-3">
        {!! Form::label('data_expiracao', 'Data Expiração') !!}                                
        {!! Form::date('data_expiracao', null, ['placeholder'=>'Data Expiração', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-3">
        <label class="form-label">Ativo</label>
        <select class="form-control simpleSelect2" id="ativo" name="ativo">
          <option value="">Selecione</option>
              <option value="1" selected="selected">Sim</option>           
              <option value="0">Não</option>        
        </select> 
    </div>
</div>
