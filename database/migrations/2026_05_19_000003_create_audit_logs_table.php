<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('table_modifiee')->nullable();
            $table->unsignedBigInteger('element_id')->nullable();
            $table->string('adresse_ip', 45)->nullable();
            $table->timestamp('date_action')->useCurrent();
            $table->timestamp('created_at')->nullable();

            $table->index(['table_modifiee', 'element_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
