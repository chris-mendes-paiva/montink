<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PEDIDOS extends Model
{
    protected $table = "pedidos";
	protected $primaryKey = 'id_pedido';
	protected $guarded = [        
		'id_pedido'        
    ];
    public $timestamps = false;
        
    public function produto()
    {
        return $this->hasOne('App\pedidos', 'id_pedido', 'id_pedido');
    }
}

// insert into `cupons` (`codigo`, `tipo_desconto`, `valor_desconto`, `data_expiracao`, `ativo`) values ('AS87WWS', Frete Grátis, 0, 2025-07-30, 1)