<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'nativephp';

    public function up(): void
    {
        if (!Schema::connection('nativephp')->hasTable('documents')) {
            Schema::connection('nativephp')->create('documents', function (Blueprint $table) {
                $table->id();
                $table->string('faculty_name');
                $table->foreignId('category_id')->constrained()->nullOnDelete();
                $table->enum('status', ['submitted', 'reviewed', 'approved', 'rejected'])->default('submitted');
                $table->text('remarks')->nullable();
                $table->date('submission_date');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('nativephp')->dropIfExists('documents');
    }
};