<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_boms', function (Blueprint $table) {
            $table->id();
            $table->double('quantity');
            $table->tinyText('uom');
            $table->string('production_bom_no')->nullable();
            $table->string('material_code')->nullable();
            $table->string('work_center_abbr')->nullable();


            Schema::disableForeignKeyConstraints();
            $table->foreign('production_bom_no')
                ->references('production_bom_no')
                ->on('bc_boms')
                ->nullOnDelete();
            $table->foreign('material_code')
                ->references('code')
                ->on('materials')
                ->nullOnDelete();
            $table->foreign('work_center_abbr')
                ->references('abbr')
                ->on('work_centers')
                ->nullOnDelete();
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_boms');
    }
};
