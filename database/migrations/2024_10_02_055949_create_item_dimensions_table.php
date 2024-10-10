<?php

use App\Models\Item;
use App\Models\ItemDimension;
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
        Schema::create('item_dimensions', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->foreign('item_code')->references('code')->on('items')->cascadeOnDelete();
            $table->float('length');
            $table->float('width');
            $table->float('height');
            $table->string('sqm');
            $table->float('s_weight')->comment('standard weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_dimensions');
    }
};
