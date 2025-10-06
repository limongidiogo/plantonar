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
            Schema::table('profiles', function (Blueprint $table) {
                // Adiciona a coluna para o caminho da foto após a coluna 'user_type'
                $table->string('caminho_foto_perfil')->nullable()->after('user_type');
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('caminho_foto_perfil');
        });
    }

};
