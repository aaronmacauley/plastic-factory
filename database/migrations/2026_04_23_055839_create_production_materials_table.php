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
        Schema::create('production_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();


            $table->uuid('production_id');
            $table->foreign('production_id')
                ->references('id')
                ->on('productions')
                ->cascadeOnDelete();

            $table->uuid('material_id');
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->cascadeOnDelete();

            $table->decimal('qty', 15, 2);
            $table->decimal('cost', 15, 2); // qty * cost_per_unit

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_materials');
    }
};
