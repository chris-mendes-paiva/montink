<div class="form-row">  
    <div class="form-group col-md-4">
        <label class="form-label">Produtos</label>
        <select class="form-control simpleSelect2" id="id_produto" name="id_produto" placeholder="Produto" >
            <option value="">Selecione</option>
            @foreach(\App\PRODUTOS::orderBy('nome_produto')->get() as $produto)
            <option value="{{$produto->id_produto}}">{{$produto->nome_produto}} - {{$produto->preco}}</option>
            @endforeach
        </select> 
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('quantidade', 'Quantidade') !!}                                
        {!! Form::number('quantidade', null, ['placeholder'=>'Quantidade', 'class' => 'form-control', "required"]) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('cupom', 'Cupom Aplicável') !!}                                
        {!! Form::text('cupom', null, ['placeholder'=>'Cupom Aplicável', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('nome_usuario', 'Nome Completo') !!}                                
        {!! Form::text('nome_usuario', null, ['placeholder'=>'Nome Completo', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('cpf_usuario', 'CPF') !!}                                
        {!! Form::text('cpf_usuario', null, ['placeholder'=>'CPF', 'class' => 'form-control']) !!}   
    </div>
    {{-- Change para preencher Endereço --}}
    <div class="form-group col-md-4">
        {!! Form::label('cep', 'CEP') !!}                                
        {!! Form::text('cep', null, ['placeholder'=>'CEP', 'class' => 'form-control']) !!}   
    </div>
    
    <div class="form-group col-md-4">
        {!! Form::label('estado', 'Estado') !!}                                
        {!! Form::text('estado', null, ['placeholder'=>'Estado', 'class' => 'form-control', 'disabled']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('cidade', 'Cidade') !!}                                
        {!! Form::text('cidade', null, ['placeholder'=>'Cidade', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('bairro', 'Bairro') !!}                                
        {!! Form::text('bairro', null, ['placeholder'=>'Bairro', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('endereco', 'Endereço') !!}                                
        {!! Form::text('endereco', null, ['placeholder'=>'Endereço', 'class' => 'form-control']) !!}   
    </div>
    <div class="form-group col-md-1">
        {!! Form::label('number', 'N°') !!}                                
        {!! Form::text('number', null, ['placeholder'=>'N°', 'class' => 'form-control']) !!}   
    </div>
    </div>
</div>

<script>

    var doneTypingInterval = 1500;
    var typingTimer;
    var isTyping = false;

    var myField = document.getElementById("cep");

    myField.addEventListener("keyup", function (event) {
      isTyping = true;
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function () {
        doneTyping(myField.value);
      }, doneTypingInterval);
    });
    

    function doneTyping(textoDigitado) {

      if (textoDigitado.length >= 6) {

            $.ajax({
                url:'https://viacep.com.br/ws/'+ textoDigitado +'/json/',
                data: {
                    data: textoDigitado,
                },
                method: "GET",
                async: true,
                dataType: "json",
                success: function (json) {
                    console.log(json)              

                    document.getElementById('estado').value = json['estado'];
                    document.getElementById('cidade').value = json['localidade'];
                    document.getElementById('bairro').value = json['bairro'];
                    document.getElementById('endereco').value = json['logradouro'];
                    

                },         
                error: function (res) {
            
            },
            });
        }      
    }

</script>