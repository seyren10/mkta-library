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
        Schema::create('items', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->string('code')->primary();
            $table->string('parent_code')->index();
            $table->string('description');
            $table->string('prod_materials');
            $table->string('prod_finish')->default('Handpainted');
            $table->string('routing_no')->nullable();
            $table->string('production_bom_no')->nullable();


            $table->foreign('routing_no')
                ->references('routing_no')
                ->on('bc_routings')
                ->nullOnDelete();
            $table->foreign('production_bom_no')
                ->references('production_bom_no')
                ->on('bc_boms')
                ->nullOnDelete();
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
