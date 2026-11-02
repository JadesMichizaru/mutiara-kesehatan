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
            $table->uuid('id')->primary();
                        // Menghubungkan user_id (UUID) ke users.id (UUID)
                        $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
                        $table->string('nik', 16)->unique();
                        $table->enum('gender', ['Laki-Laki', 'Perempuan']);
                        $table->date('date_of_birth');
                        $table->text('address');
                        $table->string('blood_type', 6)->nullable();
                        $table->timestamps();
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
