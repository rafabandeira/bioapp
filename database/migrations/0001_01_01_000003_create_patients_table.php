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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // O link para o SaaS: Qual profissional (User) é "dono" deste paciente
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Campos do metabox 'dados.php'
            $table->string('name'); // pab_nome
            $table->string('email')->nullable(); // pab_email
            $table->string('phone')->nullable(); // pab_celular
            $table->date('birth_date')->nullable(); // pab_nascimento
            $table->enum('gender', ['M', 'F'])->nullable(); // pab_genero
            $table->decimal('height', 5, 1)->nullable(); // pab_altura (em cm, ex: 170.5)

            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};