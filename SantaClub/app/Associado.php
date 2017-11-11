<?php
namespace App;
use App\CustomModel;
use App\Helper\Traits\DataViewer;
use DB;
class Associado extends CustomModel {
  use DataViewer;

  private $dv_hidden = [
    'padrinho_id',
    'devedor',
    'foto',
    'ativo',
    'apelido',
  ];

  private $dv_config = [
    [
      'label' => '#',
      'name'=>'id',
      'search'=>true
    ],
    [
      'name'=>'nome',
      'search'=>true
    ],
    [
      'name'=>'apelido',
      'search'=>true
    ],
    [
      'name'=>'foto',
    ],
    [
      'name'=>'ativo',
    ],
    [
      'label' => 'C.P.F.',
      'name'=>'cpf',
      'search'=>true
    ],
    [
      'label' => 'R.G.',
      'name'=>'rg',
      'search'=>true
    ],
    [
      'name'=>'data_nascimento',
      'search'=>true
    ],
    [
      'name'=>'cracha',
      'search'=>true
    ],
    [
      'name'=>'devedor',
    ],
    [
      'name'=>'padrinho_id',
      'search'=>true
    ],
    [
      'name'=>'padrinho_nome',
      'search'=>true
    ],
  ]; 

  protected $fillable = ['cracha'];
  protected $primaryKey = 'pessoa_id';

  public function pessoa() {
    return $this->belongsTo('App\Pessoa','pessoa_id','id');
  }

  public function padrinho() {
    return $this->belongsTo(Associado::class,'padrinho_id','pessoa_id');
  }

  public function vales() {
    return $this->hasMany('App\Vales');
  }


  public static function tableData(){
    return DB::table('pessoas as p')
    ->join('associados as a','p.id', '=', 'a.pessoa_id','left outer')
    ->join('fisicas as f', 'p.id', '=', 'f.pessoa_id','left outer')
    ->join('pessoas as pad','pad.id', '=', 'a.padrinho_id','left outer')
    ->select('p.id', 'p.nome', 'p.apelido', 'p.foto', 'p.ativo',
     'f.cpf', 'f.rg', DB::raw('DATE_FORMAT(f.data_nascimento,"%d/%m/%Y") as data_nascimento'),
     'a.cracha', 'a.devedor', 'a.padrinho_id',
     'pad.nome as padrinho_nome');
  }

  public function getDataNascimentoAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y');
  }

}
