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
            $table->renameColumn('first_name', 'nombre');
            $table->dropColumn('last_name');
            $table->string('telefono', 50)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telefono');
            $table->renameColumn('nombre', 'first_name');
            $table->string('last_name')->after('first_name')->nullable();
        });
    }
};
