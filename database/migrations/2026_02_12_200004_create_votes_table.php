<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('choice');
            $table->timestamps();

            $table->unique(['user_id', 'event_id']); // One User One Vote
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
