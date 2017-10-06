<?php

namespace App;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Helper\Traits\DataViewer;

class Movimento extends CustomModel {
  use SoftDeletes;
  use DataViewer;

  protected $dates = ['criado_em','excluido_em'];

  protected $fillable = [
    'conta_id',
    'categoria_id',
    'emitente_id',
    'tipo_entrada',
    'descricao',
    'valor',
    'dt_vencimento',
    'status',
    'obs',
    'transferencia_id',
    'movimento_id',
  ];
  public $timestamps = true;

  protected $hidden = [
    'criado_em',
    'atualizado_em',
    'excluido_em',
    'categoria'
  ];

  protected $dv_pagination_limit = 15;
  protected $dv_config = [
    [
      'label' => 'Cod',
      'name' => 'categoria_id',
      'search' => true
    ],
    [
      'label' => 'Descrição',
      'name' => 'descricao',
      'search' => true
    ],
    [
      'label' => 'Valor',
      'name' => 'valor',
      'search' => true
    ],
  ];

  //Accessors
  protected $appends = ['total_parcial','categoria_label','categoria_cor'];

  //mutators
  public function getTotalParcialAttribute() {
    return $this->parciais()->sum('valor');
  }
  public function getCategoriaLabelAttribute() {
    return $this->categoria->label;
  }
  public function getCategoriaCorAttribute() {
    return $this->categoria->color;
  }


  public static function movimentacoes() {
    return Movimento::whereNull('movimento_id');
  }

  public function conta() {
    return $this->belongsTo('App\Conta');
  }

  public function categoria() {
    return $this->belongsTo('App\Categoria');
  }

  public function transferencia() {
    return $this->belongsTo('App\Categoria');
  }

  public function parciais() {
    return $this->hasMany('App\Movimento');
  }

}
