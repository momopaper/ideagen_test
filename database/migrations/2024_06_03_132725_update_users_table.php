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
        Schema::table('users', function (Blueprint $table) {
            // Remove the unique constraint from the email column
            $table->dropUnique(['email']);

            // Add new columns
            $table->string('ic');
            $table->string('epf_no');
            $table->string('socso_no');
            $table->string('employee_no');

            // Add soft deletes column
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the unique constraint to the email column
            $table->unique('email');

            // Drop the new columns
            $table->dropColumn('ic');
            $table->dropColumn('epf_no');
            $table->dropColumn('socso_no');
            $table->dropColumn('employee_no');

            // Drop the soft deletes column
            $table->dropSoftDeletes();
        });
    }
};
