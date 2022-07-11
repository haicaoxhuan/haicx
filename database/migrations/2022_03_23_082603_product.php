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
        Schema::create('product', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('sku', 20)->unique();
            $table->string('name', 255);
            $table->unsignedBigInteger('stock');
            $table->string('avatar', 255);
            $table->date('expired_at');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->boolean('flag_delete')->default(0); 
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
