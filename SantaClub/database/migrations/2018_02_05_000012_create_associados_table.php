<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'associados';

    /**
     * Run the migrations.
     * @table associados
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('pessoa_id');
            $table->integer('cracha')->nullable();
            $table->integer('padrinho_id')->nullable();
            $table->boolean('devedor')->default('0');

            $table->index(["padrinho_id"], 'fk_associados_associados1_idx');


            $table->foreign('padrinho_id', 'fk_associados_associados1_idx')
                ->references('pessoa_id')->on('associados')
                ->onDelete('set null')
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
