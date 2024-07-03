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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id');
            $table->date('date');
            $table->unsignedBigInteger('inventory_id');
            $table->string('quantity');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->comment('1=submitted, 2=follow-up, 3=done')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('note')->nullable();
            $table->string('attachment')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();

            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
