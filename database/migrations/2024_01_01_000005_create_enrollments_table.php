<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained();
            $table->decimal('paid_price', 8, 2);
            $table->timestamps();
            $table->unique(['user_id', 'package_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};