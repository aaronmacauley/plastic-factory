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
        Schema::create('bom_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('bom_id');
            $table->foreign('bom_id')
                ->references('id')
                ->on('boms')
                ->cascadeOnDelete();

            $table->uuid('item_id'); // bahan / sub-assembly
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->decimal('qty', 15, 4);

            $table->timestamps();

            $table->unique(['bom_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_details');
    }
};
