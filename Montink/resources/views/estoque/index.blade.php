@extends('layouts.app')

@section('content')
   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Estoque</div>                                     
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
                                                    <label class="form-label">Nome Produto</label>
                                                    <input type="text" class="form-control" name="nome_produto" id="nome_produto" placeholder="Nome Produto">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label" id="descricao" style="cursor:pointer;">Descrição</label>
                                                    <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Descrição">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Preço</label>
                                                    <input type="number" class="form-control" name="preco" id="preco" placeholder="Preço">
                                                </div>                      
                                                <div class="form-group col-md-3">
                                                    <button id="busca" name="busca" type="button" class="btn btn-primary">Busca</button>
                                                </div>
                                            </div>
                                        </div>             			                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                        <div class="card-body">                                                                                                     
                                            <table class="table table-bordered table-hover display nowrap dataTable" id="table" width="100%">

                                                <thead>
                                                    <tr>                                                                                           
                                                        <th>Nome</th><!-- CAD_CLIENTE - nome_cliente -->
                                                        <th>Descrição</th><!-- TB_GARI - num_matricula -->  
                                                        <th>Preço</th>
                                                        <th>Estoque</th>
                                                        <th>ID</th><!-- TB_GARI - nom_gari -->
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
                    d.estoque=$("#estoque").val();                    
                }
            },
        language: {
            url: "{{ asset('dist/datatables/Portuguese-Brasil.json') }}"
        },
        columns: [        
        { data: 'nome_produto', name:'nome_produto' },
        { data: 'descricao', name:'descricao'},
        { data: 'preco', name:'preco' },
        { data: 'estoque', name:'estoque' },
        { data: 'id_produto', 
                render: function ( data, type, row, meta ) 
                {
                    return '<a href="estoque/'+row.id_produto+'/edit"><i class="align-middle mr-2 fas fa-fw fa-edit" data-feather="edit-2"></i>Editar </a>';
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

</script>
@endsection