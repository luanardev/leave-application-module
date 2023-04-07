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
        Schema::create('app_leave_approvers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stage_id');
            $table->uuid('staff_id');
            $table->uuid('campus_id');
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
        Schema::dropIfExists('app_leave_approvers');
    }
};
