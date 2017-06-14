<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExperimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('experiments')) return;
        Schema::create('experiments', function (Blueprint $table) {
            $table->increments('id');

            /* references */
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
            /* end of references */

            $table->string('name', 150);
            $table->date('date');
            $table->boolean('calculated')->default(0);
            $table->double('tax')->default(0.22);
            $table->double('budget')->default(5000);

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
        Schema::dropIfExists('experiment_budget');
        Schema::dropIfExists('experiment_kpi');
        Schema::dropIfExists('experiments');
    }
}
