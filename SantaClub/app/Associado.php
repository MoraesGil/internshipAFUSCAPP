<?php
namespace App;
use App\CustomModel;
use App\Helper\Traits\DataViewer;
use DB;
class Associado extends CustomModel {
  use DataViewer;

  protected $dv_title_column ='nome';

  private $dv_hidden = [
    'pessoa_id',
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
      'search'=>true,
      'prefix'=>'p'
    ],
    [
      'name'=>'nome',
      'search'=>true,
      'prefix'=>'p'
    ],
    [
      'name'=>'apelido',
      'search'=>true,
      'prefix'=>'p'
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
      'search'=>true,
      'prefix'=>'f'
    ],
    [
      'label' => 'R.G.',
      'name'=>'rg',
      'search'=>true,
      'prefix'=>'f'
    ],
    [
      'name'=>'data_nascimento',
      'search'=>true,
      'prefix'=>'f'
    ],
    [
      'name'=>'cracha',
      'search'=>true,
      'prefix'=>'a'
    ],
    [
      'name'=>'devedor',
    ],
    [
      'name'=>'padrinho_id',
      'search'=>true,
      'prefix'=>'a'
    ],
    [
      'name'=>'padrinho_nome',
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
     'a.pessoa_id','a.cracha', 'a.devedor', 'a.padrinho_id',
     'pad.nome as padrinho_nome')
     ->where('p.excluido_em',null);
  }

  public function getDataNascimentoAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d/m/Y');
  }

}
