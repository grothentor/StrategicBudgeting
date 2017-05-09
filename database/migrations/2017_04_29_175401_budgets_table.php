<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('budgets')) return;
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['current', 'variant'])
                ->default('variant');
            $table->integer('subdivision_id')->unsigned();
            $table->foreign('subdivision_id')
                ->references('id')
                ->on('subdivisions')
                ->onDelete('cascade');

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
        Schema::dropIfExists('budgets');
    }
}
