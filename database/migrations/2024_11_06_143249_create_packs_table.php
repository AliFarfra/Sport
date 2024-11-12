<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_packs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacksTable extends Migration
{
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('prix', 8, 2);
            $table->integer('nombre_jours');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packs');
    }
}