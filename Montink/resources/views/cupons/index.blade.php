@extends('layouts.app')

@section('content')
   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cupons</div>                                     
                    <div id="page-wrapper">   
                        <div id="page-inner">         
                            <div class="row">            
                                <div class="col-md-12">
                                    <div class="card">                     
                                        <div class="card-header">    
                                            <div class="form-row">                
                                                <a href="/home"><button id="home"  type="button" style="margin-right:2px" class="btn btn-danger" >Voltar</button></a>    
                                            </div>
                                            <br>
                                            <div id="filtros" class="form-row">
                                                <hr>                                            
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Codigo Cupom</label>
                                                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo Cupom">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label" id="tipo_desconto" style="cursor:pointer;">Tipo Desconto</label>
                                                    <input type="text" class="form-control" name="tipo_desconto" id="tipo_desconto" placeholder="Tipo Desconto">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Valor Desconto</label>
                                                    <input type="number" class="form-control" name="valor_desconto" id="valor_desconto" placeholder="Valor Desconto">
                                                </div>                      
                                                <div class="form-group col-md-3">
                                                    <button id="busca" name="busca" type="button" class="btn btn-primary">Busca</button>
                                                    <a href="/cupons/create"><button id="cadastro"  type="button" class="btn btn-primary" >Cadastro</button></a>
                                                </div>
                                            </div>
                                        </div>             			                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                        <div class="card-body">                                                                                                     
                                            <table class="table table-bordered table-hover display nowrap dataTable" id="table" width="100%">

                                                <thead>
                                                    <tr>                                                                                           
                                                        <th>Codigo</th>
                                                        <th>Tipo Desconto</th>
                                                        <th>Valor Desconto</th>
                                                        <th>Data Limite</th>
                                                        <th>Ativo</th>
                                                        <th>ID</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>            
                            </div>	    
                        </div>        
                    </div>                           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
@include('layouts.js') {{-- Se você mantiver este include aqui, ele deve vir ANTES do seu script personalizado --}}

<script type="text/javascript">
 
$(function() {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            stateSave: true,
            scrollY: 500,
            scrollX: true,
            order: [[ 1, 'desc' ]],
            dom: '<"float-left"B<"toolbar">><"float-right"f>t<"bottom"<"float-left"lri><"float-right"p>>',
            "lengthMenu": [[10, 100, 200, 300, 400, 500], [10, 100, 200, 300, 400, 500]],
            deferLoading: 0,
            buttons: [
            ],
            ajax: {
                type: 'POST',
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (d) {
                    d.id_produto=$('#id_produto').val();
                    d.nome_produto=$("#nome_produto").val();
                    d.descricao=$("#descricao").val();                    
                }
            },
        language: {
            url: "{{ asset('dist/datatables/Portuguese-Brasil.json') }}"
        },
        columns: [        
        { data: 'codigo', name:'codigo' },
        { data: 'tipo_desconto', name:'tipo_desconto'},
        { data: 'valor_desconto', name:'valor_desconto' },
        { data: 'data_expiracao', name:'data_expiracao' },
        { data: 'ativo', name:'ativo' },
        { data: 'id_cupom ', 
                render: function ( data, type, row, meta ) 
                {
                    return '<a href="cupons/'+row.id_cupom +'/edit"><i class="align-middle mr-2 fas fa-fw fa-edit" data-feather="edit-2"></i>Editar </a>\n\
                            <a href="" rowName="'+row.codigo+'" rowId="'+row.id_cupom +'" class="excluir"><i class="align-middle mr-2 fas fa-fw fa-trash excluir" data-feather="trash"></i>Excluir</a>';
                } 
            }
        ],
        drawCallback: function( settings ) {
        if(settings.iDraw > 1){
            $('#loader').addClass('invisible');
        }
    }
    });
   
    $('#busca').on('click', function(e) {
        e.preventDefault();          
        $('#filtros').collapse('hide');
        $('#loader').toggleClass('invisible');
        $('#table').DataTable().ajax.reload();
    });
});

$("body").on("click", "a.excluir", function (e) {
    e.preventDefault();
    Swal.fire({
            title: 'Deseja realmente excluir este Cupom?',
            text: $(this).attr('rowName'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then((result) => {
        if (result.value) {
        
        var token = $("meta[name='csrf-token']").attr("content");
        
        $.ajax(
        {
            url: "cupons/"+$(this).attr('rowId')+"/destroy",
            type: 'DELETE',
            data: {
                "id": $(this).attr('rowId'),
                "_token": token,
            },
            success: function (){
                Swal.fire(
                    'Deletado!',
                    'O Cupom selecionado foi deletado.',
                    'success'
                )
                $('#table').DataTable().ajax.reload();
            }
        });
        
        e.stopImmediatePropagation();
        }
    })
});
</script>

</script>
@endsection