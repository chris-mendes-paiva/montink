<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PRODUTOS;
use App\ESTOQUE;
use App\CUPONS;
use Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Excel;

class CuponsController extends Controller
{

    public function getCuponsData(Request $request){
        $query = CUPONS::orderBy('codigo', 'ASC');
      
        $query->when(!empty($request->codigo ), function ($q) use ($request) {
            return $q->where('cupons.codigo', 'like','%'.$request->codigo .'%');
        });
        $query->when(!empty($request->tipo_desconto), function ($q) use ($request) {           
            return $q->where('cupons.tipo_desconto', 'like','%'.$request->tipo_desconto.'%');
        });
        $query->when(!empty($request->valor_desconto), function ($q) use ($request) {           
            return $q->where('cupons.preco', $request->valor_desconto);
        });


        return Datatables::of($query)         
        ->addColumn('codigo', function ($lista) {
            if(isset($lista->codigo)){
                return $lista->codigo;
            }
        })
        ->addColumn('tipo_desconto', function ($lista) {
            if(isset($lista->tipo_desconto)){
                return $lista->tipo_desconto;
            }
        })
        ->addColumn('valor_desconto', function ($lista) {
            if(isset($lista->valor_desconto)){
                return $lista->valor_desconto;
            }
        })        
        ->addColumn('data_expiracao', function ($lista) {
            if(isset($lista->data_expiracao)){
                return $lista->data_expiracao;
            }
        })
        ->addColumn('ativo', function ($lista) {
            if(isset($lista->ativo)){
                return $lista->ativo;
            }
        })
        ->make(true); 
    
        
    }

    public function index(Request $request) {
        return view('cupons/index');
        
    }

    public function create() {        
        return view('cupons/cadastro');
    }
    
    public function store(Request $request) {
   
        $cupons = new CUPONS;
        
        $cupons->codigo = $request->codigo;
        $cupons->tipo_desconto = $request->tipo_desconto;
        $cupons->valor_desconto = $request->valor_desconto;
        $cupons->data_expiracao = $request->data_expiracao;
        $cupons->ativo = $request->ativo;
        
        $cupons->save();

        \Session::forget('cupons');
        return redirect('cupons')->with('success', 'Salvo com sucesso');
    }

    
    public function search(Request $request) {

    }

    public function show($id_produto) {

    }

    public function edit($id_cupom) {
        $cupons = CUPONS::find($id_cupom);
        return view('cupons.edit')->withCupons($cupons);
    }

    public function update(Request $request, $id_cupom) {
              
        $cupons = CUPONS::where('cupons.id_cupom', $id_cupom)->first();

        $input = $request->all();        
       
        $input["quanticodigodade"] = $request->codigo;
        $input["tipo_desconto"] = $request->tipo_desconto;
        $input["valor_desconto"] = $request->valor_desconto;
        $input["data_expiracao"] = $request->data_expiracao;
        $input["ativo"] = $request->ativo;
        
        $cupons->update($input);
                    
        \Session::forget('cupons');
        return redirect('cupons')->with('success', 'Salvo com sucesso');
    }
    
    public function destroy($id_cupom) {                
        $cupons = CUPONS::find($id_cupom);
        $cupons->delete();     
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
          
}
