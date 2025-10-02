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
            // Adiciona as novas colunas
                $table->date('data_nascimento')->nullable();
                $table->string('cpf', 14)->nullable()->unique(); // CPF é único
                $table->string('rg', 20)->nullable();
                $table->string('estado_civil', 50)->nullable();
                $table->string('nacionalidade', 50)->nullable();
                $table->text('endereco_completo')->nullable(); // Usamos 'text' para um endereço longo
                $table->string('telefone_celular', 20)->nullable(); // Campo para o telefone

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};
