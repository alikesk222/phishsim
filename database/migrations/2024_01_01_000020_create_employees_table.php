<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->integer('phished_count')->default(0);
            $table->integer('trained_count')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['organization_id', 'email']);
        });

        Schema::create('employee_group_pivot', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_group_id')->constrained()->cascadeOnDelete();
            $table->primary(['employee_id', 'employee_group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_group_pivot');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_groups');
    }
};
