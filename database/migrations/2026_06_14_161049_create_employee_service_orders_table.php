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
        Schema::create('EmployeeServiceOrders', function (Blueprint $table) {
            $table->id('Id');
            $table->unsignedBigInteger('EmployeeId');
            $table->unsignedBigInteger('ServiceOrderId');
    
            $table->foreign('EmployeeId')
                ->references('Id')
                ->on('Employees');
    
            $table->foreign('ServiceOrderId')
                ->references('Id')
                ->on('ServiceOrders');
    
            $table->unique(['EmployeeId', 'ServiceOrderId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('EmployeeServiceOrders');
    }
};
