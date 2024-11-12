<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrateursTable extends Migration
{
    public function up()
    {
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_debut');
            $table->string('matricule')->unique();
            $table->enum('type', ['secretaire', 'coach', 'femme_de_menage']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('administrateurs');
    }
}