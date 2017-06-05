<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExperimentCompareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('experiment_compare')) return;
        Schema::create('experiment_compare', function (Blueprint $table) {
            $table->increments('id');

            /* references */
            $table->integer('experiment_id')->unsigned();
            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onDelete('cascade');
            $table->integer('compare_id')->unsigned();
            $table->foreign('compare_id')
                ->references('id')
                ->on('compares')
                ->onDelete('cascade');
            /* end of references */

            $table->integer('value');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experiment_compare');
    }
}
