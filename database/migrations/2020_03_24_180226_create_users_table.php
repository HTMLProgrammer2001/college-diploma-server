<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->date('birthday')->nullable();
            $table->string('passport')->nullable()->unique();
            $table->string('code')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->bigInteger('commission_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('rank_id')->unsigned();
            $table->integer('role')->default(\App\User::ROLE_USER);
            $table->string('avatar')->nullable();
            $table->smallInteger('hiring_year')->nullable();
            $table->string('pedagogical_title')->nullable();
            $table->smallInteger('experience')->default(0);
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('academic_status')->nullable();
            $table->smallInteger('academic_status_year')->nullable();
            $table->string('scientific_degree')->nullable();
            $table->smallInteger('scientific_degree_year')->nullable();

            $table->rememberToken();
            $table->timestamps();

            //relations
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('rank_id')->references('id')->on('ranks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
