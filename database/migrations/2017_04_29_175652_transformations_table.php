<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('transformations')) return;
        Schema::create('transformations', function (Blueprint $table) {
            $table->increments('id');

            /* references */
            $table->integer('kpi_id')->unsigned();
            $table->foreign('kpi_id')
                ->references('id')
                ->on('kpis')
                ->onDelete('cascade');

            $table->integer('left_budget_indicator_id')->unsigned()->nullable();
            $table->foreign('left_budget_indicator_id')
                ->references('id')
                ->on('budget_indicators');

            $table->integer('right_budget_indicator_id')->unsigned()->nullable();
            $table->foreign('right_budget_indicator_id')
                ->references('id')
                ->on('budget_indicators');

            $table->integer('left_transformation_id')->unsigned()->nullable();
            $table->foreign('left_transformation_id')
                ->references('id')
                ->on('transformations');

            $table->integer('right_transformation_id')->unsigned()->nullable();
            $table->foreign('right_transformation_id')
                ->references('id')
                ->on('transformations');
            /* end of references*/

            $table->float('value')->nullable();
            $table->enum('operation', ['+', '-', '*', '/']);


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
        Schema::dropIfExists('transformations');
    }
}
