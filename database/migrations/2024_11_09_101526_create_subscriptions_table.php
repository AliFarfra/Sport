<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users
            $table->foreignId('pack_id')->constrained()->onDelete('cascade'); // Foreign key to packs
            $table->foreignId('cours_id')->constrained()->onDelete('cascade'); // Foreign key to cours
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}