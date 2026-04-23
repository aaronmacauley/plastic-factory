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
        Schema::create('journal_entry_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('journal_entry_id');
            $table->foreign('journal_entry_id')
                ->references('id')
                ->on('journals')
                ->cascadeOnDelete();

            $table->uuid('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->restrictOnDelete();

            $table->enum('position', ['debit', 'credit']);

            $table->decimal('amount', 15, 2)->default(0);

            $table->string('description')->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entry_lines');
    }
};
