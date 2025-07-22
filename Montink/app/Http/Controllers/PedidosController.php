<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PRODUTOS;
use App\ESTOQUE;
use App\CUPONS;
use App\PEDIDOS;
use Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Excel;

class PedidosController extends Controller
{

    public function getPedidosData(Request $request){
        $query = PEDIDOS::orderBy('status_pedido', 'ASC');
      
        return Datatables::of($query)         
        ->addColumn('data_pedido', function ($lista) {
            if(isset($lista->data_pedido)){
                return $lista->data_pedido;
            }
        })
        ->addColumn('status_pedido', function ($lista) {
            if(isset($lista->status_pedido)){
                return $lista->status_pedido;
            }
        })
        ->addColumn('valor_total', function ($lista) {
            if(isset($lista->valor_total)){
                return $lista->valor_total;
            }
        })        
        ->addColumn('id_cupom', function ($lista) {
            if(isset($lista->id_cupom)){
                return $lista->id_cupom;
            }
        })
        ->addColumn('produtos', function ($lista) {
            if(isset($lista->produtos)){
                return $lista->produtos;
            }
        })        
        ->addColumn('cep', function ($lista) {
            if(isset($lista->cep)){
                return $lista->cep;
            }
        })
        ->addColumn('endereco', function ($lista) {
            if(isset($lista->endereco)){
                return $lista->endereco;
            }
        })
        ->make(true); 
    
        
    }

    public function index(Request $request) {
        return view('pedidos/index');
        
    }

    public function create() {        
        return view('pedidos/cadastro');
    }
    
    public function store(Request $request) {
   
        $pedidos = new PEDIDOS;
        
        $produto = PRODUTOS::where('produtos.id_produto', $request->id_produto)->first();
        //Busco estoque disponivel
        $estoque = ESTOQUE::where('estoque.id_produto', $request->id_produto)->first();

        if($estoque->quantidade < $request->quantidade){
            return redirect('pedidos')->with('error', 'Quantidade em estoque e de '. $estoque->quantidade );
        }

        $cupom = [];
        if($request->cupom != ''){
            $cupom = CUPONS::where('cupons.codigo', $request->cupom)->where('cupons.ativo', 1)->first();
        }

        $pedidos->data_pedido = Carbon::now();
        $pedidos->status_pedido = 'Em processamento';

        $preco_final = 0;
        $produto->preco = $produto->preco * $request->quantidade;

        //Validar Cupons
        if(!empty($cupom)){
            switch ($cupom->tipo_desconto) {
                case 'Deconto':
                        $preco_final = $produto->preco - $cupom->valor_desconto;
                    break;

                case 'Frete Grátis':
                        $preco_final = $produto->preco;
                    break;  

                default: 
                    $preco_final = $produto->preco;
            }
        }else{
            //Calculo de desconto sem Cupons
            switch ($produto->preco) {
                case floatval($produto->preco) < 200 && floatval($produto->preco) > 166:
                        $preco_final = $produto->preco + 20;
                    break;

                case floatval($produto->preco) > 200:
                        $preco_final = $produto->preco;
                    break;

                case floatval($produto->preco) > 52 && floatval($produto->preco) < 166:
                        $preco_final = $produto->preco + 15;
                    break;

                default: 
                    $preco_final = $produto->preco;
            }
        }
       
        $pedidos->valor_total = $preco_final;
        $pedidos->id_cliente = 15; // Pendente criação de gestão de usuarios clientes
        $pedidos->produtos = json_encode($produto->nome_produto);
        $pedidos->endereco = $request->cidade.' '. $request->bairro .' '. $request->Endereço.' '. $request->number;
        $pedidos->cep = $request->cep;
        
        $pedidos->save();

        //Atualiza estoque
        $estoque = ESTOQUE::where('estoque.id_produto', $request->id_produto)->first();
        $input = $request->all();   
        
        $input["quantidade"] = $estoque->quantidade - $request->quantidade;
        $input["ultima_atualizacao"] = Carbon::now();
        $estoque->update($input);

        if($pedidos)

        return redirect('pedidos')->with('sucess', 'Salvo com sucesso');
    }

    
    public function search(Request $request) {

    }

    public function show($id_produto) {

    }

    public function destroy($id_produto) {                
        $pedidos = PEDIDOS::find($id_produto);
        $pedidos->delete();     
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
          
}
