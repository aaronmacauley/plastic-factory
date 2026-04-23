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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('name');

            $table->uuid('unit_id')->nullable();

            $table->string('size')->nullable();        // e.g. 40x100
            $table->string('grade')->nullable();       // P / M
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('diameter', 10, 2)->nullable();

            $table->decimal('standard_cost', 15, 2)->default(0);


            $table->decimal('price', 15, 2)->default(0);

            $table->boolean('is_active')->default(true);
            $table->enum('type', ['raw', 'wip', 'finished'])->default('raw');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
