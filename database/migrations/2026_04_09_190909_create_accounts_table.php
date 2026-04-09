<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique(); // 101, 102
            $table->string('name'); // Cash, Bank, Revenue
            $table->enum('type', [
                'asset',
                'liability',
                'equity',
                'revenue',
                'expense'
            ]);

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
