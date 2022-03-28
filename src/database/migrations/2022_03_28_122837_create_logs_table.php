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
    public function up() {
      Schema::create('logs', function (Blueprint $table) {
        $table->id();
        $table->integer('productId');
        $table->integer('userId');
        $table->integer('commandType');
        $table->string('oldPrice', 20)->nullable();
        $table->string('newPrice', 20)->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::dropIfExists('logs');
    }
};
