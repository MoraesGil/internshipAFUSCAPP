<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Conta;

class ContasTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()   {
    $faker = Factory::create();
    $model = new Conta();

    try {
      $model->create([
        'label'=>'Caixa',
        'descricao'=>$faker->text(20),
      ]);

      $model->create([
        'label'=>'Bradesco',
        'descricao'=>$faker->text(20),
      ]);

      $model->create([
        'label'=>'Itáu',
        'descricao'=>$faker->text(30),
      ]);

    } catch (\Exception $e) {
      dump('Contas ja cadastradas');
    }
  }
}
