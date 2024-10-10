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
        Schema::create('work_centers', function (Blueprint $table) {
            $table->string('abbr')->primary()->comment('Business Central column: No');
            $table->text('name')->comment('Business Central column: Name');
            $table->boolean('isFixed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_centers');
    }
};
