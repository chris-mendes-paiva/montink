@extends('layouts.app')

@section('content')
   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pedidos</div>                                     
                    <div id="page-wrapper">   
                        <div id="page-inner">         
                            <div class="row">            
                                <div class="col-md-12">
                                    <div class="card">                     
                                        <div class="card-header">    
                                            <div class="form-row">                
                                                <a href="/home"><button id="home"  type="button" style="margin-right:2px" class="btn btn-danger" >Voltar</button></a>    
                                                <button id="busca" name="busca" type="button" style="margin-right:2px" class="btn btn-primary">Buscar Pedidos</button>
                                                <a href="/pedidos/create"><button id="cadastro" style="margin-right:2px" type="button" class="btn btn-primary" >Realizar Novo Pedido</button></a>
                                            </div>
                                            <br>                                           
                                        </div>             			                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                        <div class="card-body">                                                                                                     
                                            <table class="table table-bordered table-hover display nowrap dataTable" id="table" width="100%">

                                                <thead>
                                                    <tr>                                                                                           
                                                        <th>Data Pedido</th>
                                                        <th>Status</th>
                                                        <th>Valor</th>
                                                        <th>Cupom</th>
                                                        <th>Produtos</th>
                                                        <th>Cep</th>
                                                        <th>Endereço</th>
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
        { data: 'data_pedido', name:'data_pedido' },
        { data: 'status_pedido', name:'status_pedido'},
        { data: 'valor_total', name:'valor_total' },
        { data: 'id_cupom', name:'id_cupom' },
        { data: 'produtos', name:'produtos' },
        { data: 'cep', name:'cep' },
        { data: 'endereco', name:'endereco' },
        { data: 'id_pedido ', 
                render: function ( data, type, row, meta ) 
                {
                    return '<a href="" rowName="'+row.id_pedido+'" rowId="'+row.id_pedido +'" class="excluir"><i class="align-middle mr-2 fas fa-fw fa-trash excluir" data-feather="trash"></i>Excluir</a>';
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