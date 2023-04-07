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
        Schema::create('app_leave_approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('leave_id');
            $table->uuid('stage_id');
            $table->uuid('approver_id');
            $table->enum('decision', ['Accepted', 'Rejected', 'Returned']);
            $table->text('comment')->nullable();
            $table->foreign('leave_id')->references('id')->on('app_leave_applications')->onDelete('cascade');
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
        Schema::dropIfExists('app_leave_approvals');
    }
};
