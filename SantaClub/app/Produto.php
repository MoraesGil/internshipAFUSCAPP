<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Traits\DataViewer;

class Produto extends Model {
  use DataViewer;

  protected $fillable = ['nome','descricao','preco'];
  public $timestamps = false; 

  //deixar default todos os campos para pesquisar..
  protected $dataViewerConfig = [
    'id'=>['Cod',true],
    'nome'=>['Produto',true],
    'descricao'=>['Descrição',true],
    'preco'=>['Preço',true],
  ];

}
