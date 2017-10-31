<?php

use Illuminate\Database\Seeder;
use Faker\Factory; 
use App\Estado;

class EstadosTableSeeder extends Seeder {
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()   {

    //Init Estados
    Estado::updateOrCreate(['uf'=>'AC'],['uf'=>'AC','nome'=>'Acre']);
    Estado::updateOrCreate(['uf'=>'AL'],['uf'=>'AL','nome'=>'Alagoas']);
    Estado::updateOrCreate(['uf'=>'AP'],['uf'=>'AP','nome'=>'Amapá']);
    Estado::updateOrCreate(['uf'=>'AM'],['uf'=>'AM','nome'=>'Amazonas']);
    Estado::updateOrCreate(['uf'=>'BA'],['uf'=>'BA','nome'=>'Bahia']);
    Estado::updateOrCreate(['uf'=>'CE'],['uf'=>'CE','nome'=>'Ceará']);
    Estado::updateOrCreate(['uf'=>'DF'],['uf'=>'DF','nome'=>'Distrito Federal']);
    Estado::updateOrCreate(['uf'=>'ES'],['uf'=>'ES','nome'=>'Espírito Santo']);
    Estado::updateOrCreate(['uf'=>'GO'],['uf'=>'GO','nome'=>'Goiás']);
    Estado::updateOrCreate(['uf'=>'MA'],['uf'=>'MA','nome'=>'Maranhão']);
    Estado::updateOrCreate(['uf'=>'MT'],['uf'=>'MT','nome'=>'Mato Grosso']);
    Estado::updateOrCreate(['uf'=>'MS'],['uf'=>'MS','nome'=>'Mato Grosso do Sul']);
    Estado::updateOrCreate(['uf'=>'MG'],['uf'=>'MG','nome'=>'Minas Gerais']);
    Estado::updateOrCreate(['uf'=>'PA'],['uf'=>'PA','nome'=>'Pará']);
    Estado::updateOrCreate(['uf'=>'PB'],['uf'=>'PB','nome'=>'Paraíba']);
    Estado::updateOrCreate(['uf'=>'PR'],['uf'=>'PR','nome'=>'Paraná']);
    Estado::updateOrCreate(['uf'=>'PE'],['uf'=>'PE','nome'=>'Pernambuco']);
    Estado::updateOrCreate(['uf'=>'PI'],['uf'=>'PI','nome'=>'Piauí']);
    Estado::updateOrCreate(['uf'=>'RJ'],['uf'=>'RJ','nome'=>'Rio de Janeiro']);
    Estado::updateOrCreate(['uf'=>'RN'],['uf'=>'RN','nome'=>'Rio Grande do Norte']);
    Estado::updateOrCreate(['uf'=>'RS'],['uf'=>'RS','nome'=>'Rio Grande do Sul']);
    Estado::updateOrCreate(['uf'=>'RO'],['uf'=>'RO','nome'=>'Rondônia']);
    Estado::updateOrCreate(['uf'=>'RR'],['uf'=>'RR','nome'=>'Roraima']);
    Estado::updateOrCreate(['uf'=>'SC'],['uf'=>'SC','nome'=>'Santa Catarina']);
    Estado::updateOrCreate(['uf'=>'SP'],['uf'=>'SP','nome'=>'São Paulo']);
    Estado::updateOrCreate(['uf'=>'SE'],['uf'=>'SE','nome'=>'Sergipe']);
    Estado::updateOrCreate(['uf'=>'TO'],['uf'=>'TO','nome'=>'Tocantins']);





  }
}
