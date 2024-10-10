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
        Schema::create('item_routings', function (Blueprint $table) {
            $table->id();
            $table->string('routing_no')->nullable();
            $table->string('work_center_abbr')->nullable();

            $table->integer('sequence_index')->comment('use for process index');
            $table->integer('manpower')->comment('required no. of workers for the current process');
            $table->integer('runtime')->comment('in minutes');

            $table->foreign('routing_no')
                ->references('routing_no')
                ->on('bc_routings');
            $table->foreign('work_center_abbr')
                ->references('abbr')
                ->on('work_centers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_routings');
    }
};
