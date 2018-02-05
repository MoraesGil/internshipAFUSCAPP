<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'enderecos';

    /**
     * Run the migrations.
     * @table enderecos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pessoa_id');
            $table->string('logradouro', 225);
            $table->string('bairro', 100);
            $table->string('cep', 100)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->integer('cidade_id');

            $table->index(["cidade_id"], 'fk_enderecos_cidades1_idx');

            $table->index(["pessoa_id"], 'fk_enderecos_pessoas1_idx');


            $table->foreign('pessoa_id', 'fk_enderecos_pessoas1_idx')
                ->references('id')->on('pessoas')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('cidade_id', 'fk_enderecos_cidades1_idx')
                ->references('id')->on('cidades')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
