<?php

namespace App;
use App\CustomModel;
use App\Helper\Traits\DataViewer;
class Associado extends CustomModel {
  use DataViewer;

  protected $fillable = ['descricao','label'];
  public $timestamps = true;

  protected $dv_config = [
    [
      'label' => 'Cód',
      'name' => 'id',
      'search' => true
    ],
    [
      'label' => 'Descrição',
      'name' => 'descricao',
      'search' => true
    ],
    [
      'label' => 'Título',
      'name' => 'label',
      'search' => true
    ],
  ];

  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }

}
