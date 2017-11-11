<?php
/**
 * @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
 */
namespace App;

use App\CustomModel;
use App\Helper\Traits\DataViewer;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helper\Classes\BatmanBelt;

class Categoria extends CustomModel {
  use DataViewer,SoftDeletes;

  protected $fillable = ['label','descricao','color'];
  public $timestamps = true;

  protected $rules = [
    'label'=>'required|max:45|min:3|unique:categorias,label,@except,id',
    'descricao'=>'max:100',
    'color'=>['required','regex:/'.BatmanBelt::HEX_PATTERN.'/'],
  ];

  protected $hidden = [
    'criado_em',
    'atualizado_em',
    'excluido_em',
  ];

  //Accessors
  protected $appends = ['custom_label'];

  //mutators
  public function getCustomLabelAttribute() {
    return '<i class="fa fa-square fa-fw" style="color:'.$this->color.'"></i> '.$this->label;
  }

  protected $dv_title_column ='custom_label';

  private $dv_hidden = [
    'id',
    'color',
    'label',
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
    return $this->hasMany(Movimento::class);
  }


}
