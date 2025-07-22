<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PRODUTOS;
use App\ESTOQUE;
use Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Excel;

class EstoqueController extends Controller
{

    public function getEstoqueData(Request $request){
        $query = ESTOQUE::join('produtos', 'estoque.id_produto', '=', 'produtos.id_produto')
            ->select([
                'produtos.id_produto',
                'produtos.nome_produto',
                'produtos.descricao',
                'produtos.preco',
                'estoque.quantidade'])
            ->orderBy('nome_produto', 'ASC');
      
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
        ->addColumn('estoque', function ($lista) {
            if(isset($lista->quantidade)){
                return $lista->quantidade;
            }
        })

        ->make(true);         
    }

    public function index(Request $request) {
        return view('estoque/index');        
    }
    
    public function search(Request $request) {

    }

    public function show($id_produto) {

    }

    public function edit($id_produto) {
        $estoque = PRODUTOS::find($id_produto);
        return view('estoque.edit')->withEstoque($estoque);
    }

    public function update(Request $request, $id_produto) {
              
        $produtos = ESTOQUE::where('estoque.id_produto', $id_produto)->first();

        $input = $request->all();        
       
        $input["quantidade"] = $request->estoque;
        $input["ultima_atualizacao"] = Carbon::now();
        $produtos->update($input);
                    
        \Session::forget('estoque');
        return redirect('estoque')->with('success', 'Salvo com sucesso');
    }
    
    public function destroy($id_produto) {                
        return false;
    }
          
}
