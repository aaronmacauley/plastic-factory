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
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('expense_number')->unique();
            $table->date('expense_date');

            $table->uuid('expense_categories_id');
            $table->foreign('expense_categories_id')
                ->references('id')
                ->on('expense_categories')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);

            $table->text('description')->nullable();
 
            $table->uuid('journal_entry_id');
            $table->foreign('journal_entry_id')
                ->references('id')
                ->on('journal_entries')
                ->cascadeOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
