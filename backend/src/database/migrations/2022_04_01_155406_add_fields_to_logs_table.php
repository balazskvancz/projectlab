<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
    * Run the migrations.
    *
    * @return void
    */
  public function up() {
    Schema::table('logs', function (Blueprint $table) {
      $table->string('oldDescription', 500)->nullable();
      $table->string('newDescription', 500)->nullable();
    });
  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::table('logs', function (Blueprint $table) {
        $table->dropColumn('oldDescription');
        $table->dropColumn('newDescription');
      });
    }
};
