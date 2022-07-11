<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',100)->unique();
            $table->string('user_name',100)->unique();
            $table->date('birthday')->nullable();
            $table->string('fist_name',100);
            $table->string('last_name',100);
            $table->string('password');
            $table->string('status');
            $table->boolean('flag_delete')->default(0);
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
        Schema::dropIfExists('admin');
    }
};
