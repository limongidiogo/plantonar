<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
 * Run the migrations.
 */
    public function up(): void
    {
        Schema::create('plantoes', function (Blueprint $table) {
            $table->id(); // ID único do plantão

            // Chave estrangeira para conectar o plantão ao hospital (perfil)
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');

            $table->string('specialty'); // Especialidade médica necessária (ex: Cardiologia, Pediatria)
            $table->date('date'); // Data do plantão
            $table->time('start_time'); // Horário de início
            $table->time('end_time'); // Horário de término
            $table->decimal('remuneration', 10, 2); // Valor da remuneração (ex: 1200.00)
            $table->text('details')->nullable(); // Detalhes ou observações adicionais (opcional)
            
            // Status do plantão: 'disponivel', 'preenchido', 'cancelado'
            $table->string('status')->default('disponivel'); 

            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantaos');
    }
};
