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
        Schema::create('Employees', function (Blueprint $table) {
            $table->id('Id');
            $table->string('FirstName', 64);
            $table->string('LastName', 64);
            $table->string('Email', 128);
            $table->string('Phone', 32);
            $table->string('Position', 64);
            $table->text('Notes')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->dateTime('CreationDateTime');
            $table->dateTime('EditDateTime');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('Employees');
    }
};
