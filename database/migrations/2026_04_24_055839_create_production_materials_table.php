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

            $table->uuid('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->uuid('bom_id')->nullable();
            $table->foreign('bom_id')
                ->references('id')
                ->on('boms')
                ->nullOnDelete();

            $table->decimal('qty', 15, 4);
            $table->decimal('cost', 15, 2);

            $table->decimal('unit_cost', 15, 2)->default(0);

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
