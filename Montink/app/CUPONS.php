<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CUPONS extends Model
{
    protected $table = "cupons";
	protected $primaryKey = 'id_cupom';
	protected $guarded = [        
		'id_cupom'        
    ];
    public $timestamps = false;
        
    public function produto()
    {
        return $this->hasOne('App\cupons', 'id_cupom', 'id_cupom');
    }
}

// insert into `cupons` (`codigo`, `tipo_desconto`, `valor_desconto`, `data_expiracao`, `ativo`) values ('AS87WWS', Frete Grátis, 0, 2025-07-30, 1)