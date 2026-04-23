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
        Schema::create('production_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->decimal('hours', 10, 2)->default(0);
            $table->decimal('cost', 15, 2)->default(0);


            $table->uuid('production_id')->nullable();
            $table->foreign('production_id')
                ->references('id')
                ->on('productions')
                ->nullOnDelete();

            $table->uuid('machine_id')->nullable();
            $table->foreign('machine_id')
                ->references('id')
                ->on('machines')
                ->nullOnDelete();

            $table->decimal('output', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_details');
    }
};
