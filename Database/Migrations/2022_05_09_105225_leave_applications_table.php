<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_leave_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('staff_id');
            $table->uuid('campus_id');
            $table->uuid('type_id');
            $table->uuid('stage_id');
            $table->uuid('financial_year');
            $table->integer('period');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('summary')->nullable();
            $table->string('delegation')->nullable();
            $table->string('document')->nullable();
            $table->enum('request_status', ['Draft', 'Processing', 'Completed'])->default('Draft');
            $table->enum('approval_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->enum('leave_status', ['Pending', 'Active', 'Inactive'])->default('Pending');
            $table->enum('return_status', ['Pending', 'Returning', 'Returned'])->default('Pending');
            $table->date('return_date')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_leave_applications');
    }
};
