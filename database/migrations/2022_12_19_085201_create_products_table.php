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
            $table->string('name');
            $table->decimal('price', 8, 3);
            $table->string('image')->nullable();
            $table->string('description');
            $table->timestamps();
            $table->foreignId('product_type_id')->constrained()
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained()
                ->onDelete('cascade');
            $table->foreignId('stock_id')->constrained()
                ->onDelete('cascade');
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
