<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Title', 64)->unique();
            $table->text('Description')->nullable();
            $table->dateTime('CreationDateTime');
            $table->dateTime('EditDateTime');
            $table->boolean('IsActive')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};