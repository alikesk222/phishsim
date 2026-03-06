<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable();
            $table->string('logo')->nullable();
            $table->enum('plan', ['free', 'starter', 'pro', 'enterprise'])->default('free');
            $table->integer('employee_limit')->default(10);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('role', ['owner', 'admin', 'viewer'])->default('owner');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['organization_id', 'role']);
        });
        Schema::dropIfExists('organizations');
    }
};
