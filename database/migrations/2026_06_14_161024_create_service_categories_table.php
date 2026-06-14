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
        Schema::create('ServiceCategories', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Title', 64);
            $table->text('Description');
            $table->text('Notes')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->dateTime('CreationDateTime');
            $table->dateTime('EditDateTime');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('ServiceCategories');
    }
};
