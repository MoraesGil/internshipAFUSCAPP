<?php
/**
 * @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
 * @var [type]
 */
namespace App;
use App\CustomModel;
use App\Helper\Traits\DataViewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends CustomModel {
  use DataViewer,SoftDeletes;

  protected $fillable = ['descricao','label'];
  public $timestamps = true;


  protected $dv_title_column ='label';

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
