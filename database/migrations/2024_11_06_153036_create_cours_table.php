<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table already exists before creating it
        if (!Schema::hasTable('cours')) {
            Schema::create('cours', function (Blueprint $table) {
                $table->id();
                $table->string('nom'); // Add other fields as needed
                $table->decimal('prix', 8, 2); // Example: price field
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};