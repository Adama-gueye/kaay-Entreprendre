<?php

use App\Models\Livrable;
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
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('objectif');
            $table->string('consigne');
            $table->enum('etat',['activer','desactiver']);
            $table->unsignedBigInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ressources');
    }
};
