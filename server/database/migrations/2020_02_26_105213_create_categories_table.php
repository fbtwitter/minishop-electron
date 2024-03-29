<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->string('slug')->unique();
          $table->string('image')->nullable();
          $table->enum('status', ['PUBLISH', 'DRAFT'])->default('PUBLISH');
          $table->timestamps();
          $table->softDeletes();
          $table->integer('created_by')->nullable();
          $table->integer('updated_by')->nullable();
          $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
