<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assign_to')->constrained('users')->onDelete('cascade');
            $table->foreignId('assign_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('due_date');
            $table->enum('priority', ['high', 'medium', 'low']);
            $table->string('bucket')->nullable();
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->text('location')->nullable();
            $table->text('status')->nullable();
            $table->text('task_completion_status')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
