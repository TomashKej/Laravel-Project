<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->date('DateOfBirth')->nullable()->after('LastName');
            $table->string('City', 64)->after('Address');
            $table->string('PostCode', 16)->after('City');

            $table->unsignedBigInteger('CreatedByUserId')->nullable()->after('EditDateTime');
            $table->unsignedBigInteger('UpdatedByUserId')->nullable()->after('CreatedByUserId');
            $table->unsignedBigInteger('DeletedByUserId')->nullable()->after('UpdatedByUserId');
            $table->dateTime('DeletedDateTime')->nullable()->after('DeletedByUserId');

            $table->foreign('CreatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('UpdatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('DeletedByUserId')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('CreatedByUserId')->nullable()->after('EditDateTime');
            $table->unsignedBigInteger('UpdatedByUserId')->nullable()->after('CreatedByUserId');
            $table->unsignedBigInteger('DeletedByUserId')->nullable()->after('UpdatedByUserId');
            $table->dateTime('DeletedDateTime')->nullable()->after('DeletedByUserId');

            $table->foreign('CreatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('UpdatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('DeletedByUserId')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('servicecategories', function (Blueprint $table) {
            $table->unsignedBigInteger('CreatedByUserId')->nullable()->after('EditDateTime');
            $table->unsignedBigInteger('UpdatedByUserId')->nullable()->after('CreatedByUserId');
            $table->unsignedBigInteger('DeletedByUserId')->nullable()->after('UpdatedByUserId');
            $table->dateTime('DeletedDateTime')->nullable()->after('DeletedByUserId');

            $table->foreign('CreatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('UpdatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('DeletedByUserId')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('serviceitems', function (Blueprint $table) {
            $table->unsignedBigInteger('CreatedByUserId')->nullable()->after('EditDateTime');
            $table->unsignedBigInteger('UpdatedByUserId')->nullable()->after('CreatedByUserId');
            $table->unsignedBigInteger('DeletedByUserId')->nullable()->after('UpdatedByUserId');
            $table->dateTime('DeletedDateTime')->nullable()->after('DeletedByUserId');

            $table->foreign('CreatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('UpdatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('DeletedByUserId')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('serviceorders', function (Blueprint $table) {
            $table->unsignedBigInteger('CreatedByUserId')->nullable()->after('EditDateTime');
            $table->unsignedBigInteger('UpdatedByUserId')->nullable()->after('CreatedByUserId');
            $table->unsignedBigInteger('DeletedByUserId')->nullable()->after('UpdatedByUserId');
            $table->dateTime('DeletedDateTime')->nullable()->after('DeletedByUserId');

            $table->foreign('CreatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('UpdatedByUserId')->references('id')->on('users')->nullOnDelete();
            $table->foreign('DeletedByUserId')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['CreatedByUserId']);
            $table->dropForeign(['UpdatedByUserId']);
            $table->dropForeign(['DeletedByUserId']);

            $table->dropColumn([
                'DateOfBirth',
                'City',
                'PostCode',
                'CreatedByUserId',
                'UpdatedByUserId',
                'DeletedByUserId',
                'DeletedDateTime',
            ]);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['CreatedByUserId']);
            $table->dropForeign(['UpdatedByUserId']);
            $table->dropForeign(['DeletedByUserId']);

            $table->dropColumn([
                'CreatedByUserId',
                'UpdatedByUserId',
                'DeletedByUserId',
                'DeletedDateTime',
            ]);
        });

        Schema::table('servicecategories', function (Blueprint $table) {
            $table->dropForeign(['CreatedByUserId']);
            $table->dropForeign(['UpdatedByUserId']);
            $table->dropForeign(['DeletedByUserId']);

            $table->dropColumn([
                'CreatedByUserId',
                'UpdatedByUserId',
                'DeletedByUserId',
                'DeletedDateTime',
            ]);
        });

        Schema::table('serviceitems', function (Blueprint $table) {
            $table->dropForeign(['CreatedByUserId']);
            $table->dropForeign(['UpdatedByUserId']);
            $table->dropForeign(['DeletedByUserId']);

            $table->dropColumn([
                'CreatedByUserId',
                'UpdatedByUserId',
                'DeletedByUserId',
                'DeletedDateTime',
            ]);
        });

        Schema::table('serviceorders', function (Blueprint $table) {
            $table->dropForeign(['CreatedByUserId']);
            $table->dropForeign(['UpdatedByUserId']);
            $table->dropForeign(['DeletedByUserId']);

            $table->dropColumn([
                'CreatedByUserId',
                'UpdatedByUserId',
                'DeletedByUserId',
                'DeletedDateTime',
            ]);
        });
    }
};