<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('rotas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('budgeted_hours')->default(0);
            $table->integer('staffed_hours')->default(0);
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff')->nullable();
            $table->integer('rota_id')->unsigned();
            $table->integer('day')->nullable();
            $table->time('starts_at')->nullable();
            $table->time('ends_at')->nullable();
            $table->string('shift_type')->nullable();
            $table->float('work_hours', 4,2);
            $table->timestamps();
        });
        Schema::table('shifts', function (Blueprint $table) {
            $table->foreign('rota_id')->references('id')->on('rotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shifts');
        Schema::drop('rotas');
    }
}
