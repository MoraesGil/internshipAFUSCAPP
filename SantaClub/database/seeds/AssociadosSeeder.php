<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Pessoa;
use App\Associado;

class AssociadosSeeder extends Seeder {
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()   {

    $faker = Factory::create();
    $padrinhoId = null;
    $filepath = storage_path('avatars');

    if(!File::exists($filepath)){
      File::makeDirectory($filepath);
    }

    $model = new Pessoa();
    $isExterno = false;

    foreach (range(1,50) as $i) {
      DB::beginTransaction();
      try {
        $isExterno = $faker->boolean(30) && Associado::where('cracha', '!=', null)->count()>0;

        $pes = $model->create([
          'nome'    => $faker->name,
          'apelido' => $faker->firstName,
          'foto'    => $faker->boolean(30) ? $faker->image($filepath,80,80, 'people', false) : null,
          'ativo'   => $faker->boolean(98),
          ])->pessoaFisica()->create([
            'cpf'=>$faker->numerify($string = '#########'),
            'rg'=>$faker->numerify($string = '############'),
            'data_nascimento'=>$faker->dateTimeThisCentury
            ])->pessoa;

            if ($isExterno) {
              $offset = $faker->numberBetween(1,Associado::count());
              $padrinhoId = Associado::where('cracha', '!=', null)->limit(1)->skip($offset)->pluck('pessoa_id')[0];
            }

            $pes->associado()->create([
              'cracha'      => !$isExterno ? $faker->numerify($string = '####') : null,
              'padrinho_id' => $isExterno ? $padrinhoId : null
            ]);

            DB::commit();
          } catch (Exception $e) {
            dump($isExterno ? 'Associado Externo':'Associado Interno');
            dump($e->getMessage());
            dump('rollback');
            DB::rollback();
          }

        }
      }

    }
