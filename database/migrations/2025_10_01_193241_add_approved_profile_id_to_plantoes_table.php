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
        Schema::table('plantoes', function (Blueprint $table) {
            // Adiciona a coluna para o ID do perfil do médico aprovado
            $table->foreignId('approved_profile_id')->nullable()->constrained('profiles')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantoes', function (Blueprint $table) {
            //
        });
    }
};
