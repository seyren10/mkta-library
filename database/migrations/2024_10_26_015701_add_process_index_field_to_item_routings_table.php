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
        Schema::table('item_routings', function (Blueprint $table) {
            $table->dropIndex('item_routings_sequence_index_index');
            $table->tinyInteger('process_index')
                ->index()
                ->default(1)
                ->comment('next process in the same work_center e.g 1st process, 2nd process')
                ->after('work_center_abbr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_routings', function (Blueprint $table) {
            $table->dropColumn('process_index');
        });
    }
};
