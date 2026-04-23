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
        Schema::create('productions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('production_date');
            $table->decimal('total_material_cost', 15, 2)->default(0);
            $table->decimal('total_machine_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);


            $table->uuid('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->uuid('journal_id')->nullable();

            $table->foreign('journal_id')
                ->references('id')
                ->on('journals')
                ->nullOnDelete();


            $table->string('operator_name')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_output', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
