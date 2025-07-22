<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ESTOQUE extends Model
{
    protected $table = "estoque";
	protected $primaryKey = 'id_estoque';
	protected $guarded = [        
		'id_estoque'        
    ];
    public $timestamps = false;
        
    public function produto()
    {
        return $this->hasOne('App\estoque', 'id_produto', 'id_produto');
    }
}

//INSERT INTO `produtos` (`id_produto`, `nome_produto`, `descricao`, `preco`) VALUES (NULL, 'Teclado Mecânico - Multilaser', 'Teclados Mecânico multilaser preto ', '175,90');