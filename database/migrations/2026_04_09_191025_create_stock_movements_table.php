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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();


            $table->uuid('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->enum('type', ['in', 'out']);

            $table->decimal('qty', 15, 4);
            $table->decimal('price', 15, 2)->default(0);

            // link ke journal
            $table->uuid('journal_entry_id')->nullable();
            $table->foreign('journal_entry_id')
                ->references('id')
                ->on('journal_entries')
                ->nullOnDelete();

            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->date('transaction_date');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
