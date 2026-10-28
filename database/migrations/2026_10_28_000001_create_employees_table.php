<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Employees = people whose attendance is tracked.
 * user_id links an employee to a login account (optional) so they can
 * use the Employee Portal. Without it they can still use the kiosk.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('employee_number', 50)->unique();
            $table->string('department', 150);
            $table->string('picture')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
