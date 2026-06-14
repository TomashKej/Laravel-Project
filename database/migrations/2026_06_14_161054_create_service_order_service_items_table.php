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
        Schema::create('ServiceOrderServiceItems', function (Blueprint $table) {
            $table->id('Id');
            $table->unsignedBigInteger('ServiceOrderId');
            $table->unsignedBigInteger('ServiceItemId');
    
            $table->foreign('ServiceOrderId')
                ->references('Id')
                ->on('ServiceOrders');
    
            $table->foreign('ServiceItemId')
                ->references('Id')
                ->on('ServiceItems');
    
            $table->unique(['ServiceOrderId', 'ServiceItemId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ServiceOrderServiceItems');
    }
};
