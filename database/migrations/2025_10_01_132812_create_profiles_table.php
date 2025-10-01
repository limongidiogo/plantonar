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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('user_type', ['medico', 'hospital']);

        // Médicos
        $table->string('crm')->nullable()->unique();
        $table->string('specialty')->nullable();

        // Hospitais
        $table->string('hospital_name')->nullable();
        $table->string('cnpj')->nullable()->unique();
        $table->string('address')->nullable();

        // Comum
        $table->string('phone_number')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
