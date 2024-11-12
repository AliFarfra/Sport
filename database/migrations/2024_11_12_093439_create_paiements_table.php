<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key referencing users table
            $table->date('date_de_paiment'); // Date of payment
            $table->decimal('pack_montant', 10, 2); // Amount for the pack
            $table->decimal('cours_montant', 10, 2); // Amount for the course
            $table->enum('types_de_paiment', ['cache', 'virement', 'carte_bancaire']); // Payment types
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}