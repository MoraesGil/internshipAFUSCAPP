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

    $filepath = storage_path('avatars');

    if(!File::exists($filepath)){
      File::makeDirectory($filepath);
    }

    $model = new Pessoa();
    $padrinhosId = null;
    $padrinhosLen = null;

    // dd(Associado::where('cracha', '!=', null)->pluck('pessoa_id'));

    foreach (range(1,10) as $i) {
      DB::beginTransaction();
      try {
        $isExterno = $faker->boolean(30);
        $pes = $model->create([
          'nome'    => $faker->name,
          'apelido' => $faker->firstName,
          'foto'    => $faker->boolean(50) ? $faker->image($filepath,80,80, 'people', false) : null,
          'ativo'   => $faker->boolean(98),
          ])->pessoaFisica()->create([
            'cpf'=>$faker->numerify($string = '#########'),
            'rg'=>$faker->numerify($string = '############'),
            'data_nascimento'=>$faker->dateTimeThisCentury
            ])->pessoa;

            if ($isExterno) {
              $padrinhosId = Associado::where('cracha', '!=', null)->pluck('pessoa_id');
              $padrinhosLen = count($padrinhosId);
            }

            $pes->associado()->create([
              'cracha'      => !$isExterno ? $faker->numerify($string = '####') : null,
              'padrinho_id' => $isExterno ? $padrinhosId[$faker->numberBetween(0,$padrinhosLen-1)] : null
            ]);

            DB::commit();
          } catch (Exception $e) {
            dump('rollback');
            DB::rollback();
          }

        }
      }

    }
