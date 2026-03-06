<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phishing_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('category'); // invoice, hr, it, delivery, social, finance
            $table->string('difficulty')->default('medium'); // easy, medium, hard
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('subject');
            $table->longText('body_html');
            $table->text('body_text')->nullable();
            $table->string('landing_page')->default('default'); // which landing page to use
            $table->boolean('is_global')->default(false); // built-in templates
            $table->json('tags')->nullable();
            $table->integer('use_count')->default(0);
            $table->timestamps();
        });

        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('html');
            $table->boolean('capture_credentials')->default(false);
            $table->boolean('is_global')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
        Schema::dropIfExists('phishing_templates');
    }
};
