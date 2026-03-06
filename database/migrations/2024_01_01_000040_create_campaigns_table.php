<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('phishing_template_id')->constrained();
            $table->foreignId('landing_page_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'running', 'paused', 'completed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            // Sending config
            $table->string('sending_profile')->default('default');  // mailgun config key
            $table->integer('send_delay_seconds')->default(0);      // delay between sends
            $table->boolean('track_opens')->default(true);
            $table->boolean('track_clicks')->default(true);
            $table->boolean('capture_credentials')->default(false);
            $table->timestamps();
        });

        Schema::create('campaign_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('token', 64)->unique(); // unique tracking token
            $table->enum('status', ['pending', 'sent', 'bounced', 'opened', 'clicked', 'submitted', 'reported'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('submitted_data')->nullable(); // captured form fields (no real passwords stored)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_targets');
        Schema::dropIfExists('campaigns');
    }
};
