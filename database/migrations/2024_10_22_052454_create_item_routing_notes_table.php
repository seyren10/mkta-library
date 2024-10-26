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
        Schema::create('item_routing_notes', function (Blueprint $table) {
            $table->id();
            $table->string('routing_details')->index()->comment('pipe separated value routing_no@work_center_abbr@process_index');
            $table->text('title');
            $table->longText('value');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_routing_notes');
    }
};
