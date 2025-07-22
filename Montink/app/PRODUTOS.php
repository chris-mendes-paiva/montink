<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PRODUTOS extends Model
{
    protected $table = "produtos";
	protected $primaryKey = 'id_produto';
	protected $guarded = [        
		'id_produto'        
    ];
    public $timestamps = false;
        
    public function produto()
    {
        return $this->hasOne('App\produtos', 'id_produto', 'id_produto');
    }
}

//INSERT INTO `produtos` (`id_produto`, `nome_produto`, `descricao`, `preco`) VALUES (NULL, 'Teclado Mecânico - Multilaser', 'Teclados Mecânico multilaser preto ', '175,90');