<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PRODUTOS;
use App\ESTOQUE;
use Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Excel;

class ProdutosController extends Controller
{

    public function getProdutosData(Request $request){
        $query = PRODUTOS::orderBy('nome_produto', 'ASC');
      
        $query->when(!empty($request->nome_produto), function ($q) use ($request) {
            return $q->where('produtos.nome_produto', 'like','%'.$request->nome_produto.'%');
        });
        $query->when(!empty($request->descricao), function ($q) use ($request) {           
            return $q->where('produtos.descricao', 'like','%'.$request->descricao.'%');
        });
        $query->when(!empty($request->preco), function ($q) use ($request) {           
            return $q->where('produtos.preco', $request->preco);
        });

        return Datatables::of($query)         
        ->addColumn('nome_produto', function ($lista) {
            if(isset($lista->nome_produto)){
                return $lista->nome_produto;
            }
        })
        ->addColumn('descricao', function ($lista) {
            if(isset($lista->descricao)){
                return $lista->descricao;
            }
        })
        ->addColumn('preco', function ($lista) {
            if(isset($lista->preco)){
                return $lista->preco;
            }
        })
        
        ->make(true); 
    
        
    }

    public function index(Request $request) {
        return view('produtos/index');
        
    }
    
    public function create() {        
        return view('produtos/cadastro');
    }
    
    public function search(Request $request) {

    }

    public function store(Request $request) {
  
        $customMessages = [        
                'nome_produto.required' => 'O campo Nome é obrigatrório'        
            ];       
            $this->validate($request, [
                'nome_produto' => 'required',
            ], $customMessages);
        
        $produto = new PRODUTOS;
        
        $produto->nome_produto = $request->nome_produto;
        $produto->descricao = $request->descricao;
        $produto->preco = $request->preco;
        
        $produto->save();

        //Salvar o Estoque 
        $estoque = new ESTOQUE;

        $estoque->id_produto = $produto->id_produto;
        $estoque->quantidade = 0;
        $estoque->ultima_atualizacao = Carbon::now();
    
        $estoque->save();

        \Session::forget('produtos');
        return redirect('produtos')->with('success', 'Salvo com sucesso');
    }

    public function show($id_produto) {

    }

    public function edit($id_produto) {
        $produto = PRODUTOS::find($id_produto);
        return view('produtos.edit')->withProduto($produto);
    }

    public function update(Request $request, $id_produto) {
              
        $produtos = PRODUTOS::find($id_produto);
        $input = $request->all();        
       
        $input["nome_produto"] = $request->nome_produto;
        $input["descricao"] = $request->descricao;
        $produto["preco"] = $request->preco;

        $produtos->update($input);
        
        \Session::forget('produtos');
        return redirect('produtos')->with('success', 'Salvo com sucesso');
    }
    
    public function destroy($id_produto) { 
        
        $produto = PRODUTOS::find($id_produto);
        $produto->delete();     
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
          
}
