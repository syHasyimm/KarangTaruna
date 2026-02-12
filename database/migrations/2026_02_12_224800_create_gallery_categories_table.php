<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->default('green'); // tailwind color name
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('gallery_category_id')->nullable()->after('id')->constrained('gallery_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('gallery_category_id');
        });

        Schema::dropIfExists('gallery_categories');
    }
};
