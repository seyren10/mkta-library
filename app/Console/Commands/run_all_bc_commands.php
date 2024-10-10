<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class run_all_bc_commands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run All Business Central commands sequentially.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('bc:fetch_bc_work_centers');
        $this->call('bc:fetch_bc_materials');
        $this->call('bc:fetch_bc_items');
        $this->call('bc:fetch_bc_item_dimensions');
        $this->call('bc:fetch_bc_bom_lines');
        $this->call('bc:fetch_bc_item_routings');
    }
}
