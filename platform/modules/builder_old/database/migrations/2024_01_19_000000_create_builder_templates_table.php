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
        Schema::create('builder_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 400)->nullable()->default('');
            $table->longText('content');
            $table->integer('author_id');
            $table->string('status', 60)->default('published');
            $table->text('js')->nullable();
            $table->text('css')->nullable();
            $table->text('topic')->nullable();
            $table->text('category')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('email')->nullable();
            $table->boolean('only_me')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builder_templates');
    }
};
