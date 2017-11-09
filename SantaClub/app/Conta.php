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

  protected $rules = [
    'label'=>'required|max:45|min:3|unique:contas,label,@except,id',
    'descricao'=>'max:100',
  ];

  protected $dv_title_column ='label';

  protected $dv_config = [
    [
      'label' => 'Cód',
      'name' => 'id',
      'search' => true
    ],
    [
      'label' => 'Título',
      'name' => 'label',
      'search' => true
    ],
    [
      'label' => 'Descrição',
      'name' => 'descricao',
      'search' => true
    ],
    [
      'label' => 'Saldo',
      'name' => 'saldo', 
    ],

  ];

  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }

}
