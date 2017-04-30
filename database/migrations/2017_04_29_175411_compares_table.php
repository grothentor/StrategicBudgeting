<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('compares')) return;
        Schema::create('compares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value');

            /* references */
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->integer('left_kpi_id')->unsigned();
            $table->foreign('left_kpi_id')
                ->references('id')
                ->on('kpis')
                ->onDelete('cascade');

            $table->integer('right_kpi_id')->unsigned();
            $table->foreign('right_kpi_id')
                ->references('id')
                ->on('kpis')
                ->onDelete('cascade');
            /* end of references*/

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
        Schema::dropIfExists('compares');
    }
}
