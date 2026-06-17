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
            $table->boolean('IsAdmin')->default(false)->after('password');
            $table->boolean('IsActive')->default(true)->after('IsAdmin');
            $table->string('SecurityQuestion', 255)->nullable()->after('IsActive');
            $table->string('SecurityAnswerHash', 255)->nullable()->after('SecurityQuestion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'IsAdmin',
                'IsActive',
                'SecurityQuestion',
                'SecurityAnswerHash',
            ]);
        });
    }
};
