<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('nativephp')->create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject_type');          // 'Document' or 'Category'
            $table->unsignedBigInteger('subject_id');
            $table->string('action');                // created, updated, deleted
            $table->string('description');
            $table->json('changes')->nullable();     // old vs new values
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('nativephp')->dropIfExists('audit_logs');
    }
};