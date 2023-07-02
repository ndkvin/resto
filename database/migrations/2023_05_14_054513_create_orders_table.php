<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();         
            $table->unsignedBigInteger("table_id");
            $table->unsignedBigInteger("created_by")->nullable();
            $table->integer('total_price')->default(0);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->foreign("table_id")->references("id")->on("tables");
            $table->foreign("created_by")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
