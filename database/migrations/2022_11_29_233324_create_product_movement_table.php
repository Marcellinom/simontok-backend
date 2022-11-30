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
        Schema::create('product_movement', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('reference_id')->nullable()->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->enum('direction', [0,1]);
            $table->float('quantity');
            $table->bigInteger('created_at');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('product');
        });

        // karena self referencing, tablenya harus dibuat dulu
        Schema::table('product_movement', fn (Blueprint $table) => $table->foreign('reference_id')->references('id')->on('product_movement'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_movement');
    }
};
