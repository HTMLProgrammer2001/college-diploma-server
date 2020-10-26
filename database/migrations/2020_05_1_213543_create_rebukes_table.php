<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebukesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebukes', function (Blueprint $table) {
            $table->id();
            $table->string('order');
            $table->date('date_presentation');
            $table->string('title', 255);
            $table->boolean('active');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            //relations
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rebukes');
    }
}
