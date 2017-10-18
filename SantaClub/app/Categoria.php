<?php

namespace App;

use App\CustomModel;
use App\Helper\Traits\DataViewer;

class Categoria extends CustomModel {
  use DataViewer;
  protected $fillable = ['label','descricao','color'];
  public $timestamps = true;

  protected $hidden = [
    'criado_em',
    'atualizado_em',
    'excluido_em',
    'color',
    'label',
  ];

  //Accessors
  protected $appends = ['custom_label'];

  //mutators
  public function getCustomLabelAttribute() {
    return '<i class="fa fa-square fa-fw" style="color:'.$this->color.'"></i> '.$this->label;

  }

  private $dv_hidden = [
    'id',
  ];

  private $dv_config = [
    [
      'label'  => 'Titulo',
      'name'   => 'custom_label',
    ],
    [
      'label'  => 'Cód',
      'name'   => 'id',
      'search' => true
    ],
    [
      'label'  => 'Descrição',
      'name'   => 'descricao',
      'search' => true
    ],
    [
      'label'  => 'Título',
      'name'   => 'label',
      'search' => true
    ],
  ];

  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }


}
