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
        Schema::create('bom_operations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('bom_id');
            $table->foreign('bom_id')
                ->references('id')
                ->on('boms')
                ->cascadeOnDelete();

            $table->uuid('machine_id');
            $table->foreign('machine_id')
                ->references('id')
                ->on('machines')
                ->cascadeOnDelete();

            $table->integer('sequence'); // urutan proses

            $table->decimal('hours', 10, 2)->default(0);
            $table->decimal('cost_per_hour', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_operations');
    }
};
