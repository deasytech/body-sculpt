<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilates_class_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('capacity_override')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['pilates_class_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
