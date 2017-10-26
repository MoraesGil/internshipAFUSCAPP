<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ContasTableSeeder::class);
        // $this->call(CategoriasTableSeeder::class);
        // $this->call(MovimentosTableSeeder::class);
        // $this->call(AssociadosSeeder::class);
        $this->call(ConvenioSeeder::class);
    }
}
