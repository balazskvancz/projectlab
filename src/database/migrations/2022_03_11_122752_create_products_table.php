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
      Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name', 191)->unique();
        $table->integer('categoryId');
        $table->string('sku', 191)->unique();
        $table->integer('price')->nullable();
        $table->string('description', 500)->nullable();
        $table->integer('creatorId');
        $table->integer('deleted')->default(0);
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
      Schema::dropIfExists('products');
    }
};
