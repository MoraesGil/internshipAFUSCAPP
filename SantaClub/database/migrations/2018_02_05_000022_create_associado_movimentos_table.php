<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociadoMovimentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'associado_movimentos';

    /**
     * Run the migrations.
     * @table associado_movimentos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('associado_id');
            $table->integer('movimento_id');
            $table->decimal('total', 7, 2)->nullable();

            $table->index(["movimento_id"], 'fk_associados_has_movimentos_movimentos1_idx');

            $table->index(["associado_id"], 'fk_associados_has_movimentos_associados1_idx');


            $table->foreign('associado_id', 'fk_associados_has_movimentos_associados1_idx')
                ->references('pessoa_id')->on('associados')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('movimento_id', 'fk_associados_has_movimentos_movimentos1_idx')
                ->references('id')->on('movimentos')
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
