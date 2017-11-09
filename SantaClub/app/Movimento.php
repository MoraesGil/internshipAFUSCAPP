<?php

namespace App;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Helper\Traits\DataViewer;

class Movimento extends CustomModel {
  use SoftDeletes;
  use DataViewer;

  protected $dates = ['criado_em','excluido_em','dt_vencimento'];

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

  protected $dv_config = [
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
  protected $appends = ['total_parcial','categoria_label','soma_parcial'];

  //mutators
  public function getTotalParcialAttribute() {
    return floatval($this->parciais()->sum('valor'));
  }
  public function getCategoriaLabelAttribute() {
    return $this->categoria->custom_label;
  }

  public function getDtVencimentoAttribute($value) {
    return Carbon::parse($value)->format('d/m/Y');
  }
  public function getValorAttribute($value) {
    return "R$ ".number_format($value, 2, ',', '.');
  }
  public function getSomaParcialAttribute() {
    return "R$ ".number_format($this->parciais()->sum('valor'), 2, ',', '.');
  }

  public static function movimentacoes() {
    return Movimento::whereNull('movimento_id')->orderBy('dt_vencimento','asc');
  }

  public function conta() {
    return $this->belongsTo('App\Conta');
  }

  public function categoria() {
    return $this->belongsTo(Categoria::class);
  }

  public function transferencia() {
    return $this->belongsTo('App\Categoria');
  }

  public function parciais() {
    return $this->hasMany('App\Movimento');
  }

}
