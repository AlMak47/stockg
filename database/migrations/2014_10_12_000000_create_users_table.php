<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone',9)->unique()->default('00224');
            $table->enum('statut',['admin','gerant'])->default('gerant');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users',function (Blueprint $table) {
          $table->enum('state',['blocked','unblocked'])->default('unblocked');
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
