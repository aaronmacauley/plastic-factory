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
        Schema::create('item_unit', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('item_id')->nullable();
            $table->uuid('unit_id')->nullable();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->nullOnDelete();

            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->nullOnDelete();

            $table->decimal('conversion_rate', 15, 4)->default(1);

            $table->boolean('is_base_unit')->default(false);

            $table->timestamps();

            $table->unique(['item_id', 'unit_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_unit');
    }
};
