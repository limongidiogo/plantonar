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
        // Alvo da alteração é a tabela 'profiles'
        Schema::table('profiles', function (Blueprint $table) {
            // Adiciona as colunas 'uf' e 'crm_status' se elas não existirem
            if (!Schema::hasColumn('profiles', 'uf')) {
                $table->string('uf', 2)->nullable()->after('crm');
            }
            if (!Schema::hasColumn('profiles', 'crm_status')) {
                $table->string('crm_status')->default('pending')->after('uf');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Código para reverter a alteração
            $table->dropColumn(['uf', 'crm_status']);
        });
    }
};
