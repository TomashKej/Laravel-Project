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
        Schema::create('ServiceItems', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Title', 64);
            $table->text('Description');
            $table->decimal('Price', 10, 2);
            $table->unsignedBigInteger('ServiceCategoryId');
            $table->text('Notes')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->dateTime('CreationDateTime');
            $table->dateTime('EditDateTime');
    
            $table->foreign('ServiceCategoryId')
                ->references('Id')
                ->on('ServiceCategories');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('ServiceItems');
    }
};
