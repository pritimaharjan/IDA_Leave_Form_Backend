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
        Schema::create('leave_balance', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('leave_id')->unique()->constrained('leaves')->onDelete('cascade');
            $table->string('year')->nullable();
            $table->integer('total_allocated')->nullable();
            $table->integer('used_days')->default(0)->nullable();
            $table->integer('remaining_days')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balance');
    }
};
