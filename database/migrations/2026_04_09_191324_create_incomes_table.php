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
        Schema::create('incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('income_number')->unique();
            $table->date('income_date');

            $table->uuid('income_category_id');

            $table->foreign('income_category_id')
                ->references('id')
                ->on('income_categories')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);

            $table->text('description')->nullable();

            // link ke accounting journal
            $table->uuid('journal_entry_id')->nullable();
            $table->foreign('journal_entry_id')
                ->references('id')
                ->on('journal_entries')
                ->nullOnDelete();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
