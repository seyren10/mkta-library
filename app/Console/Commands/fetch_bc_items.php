<?php

namespace App\Console\Commands;

use App\Enums\BcContext;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\BusinessCentral\BcItemService;
use App\Services\BusinessCentral\BcDataTransformer;
use App\Services\BusinessCentral\BusinessCentralHttpClient;

class fetch_bc_items extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_bc_items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch business central item list data';

    /**
     * Execute the console command.
     */
    public function handle(
        BusinessCentralHttpClient $client,
        BcItemService $bcItemService
    ) {
        $startTime = time();


        $jsonResponse = $client->getByContext(BcContext::Items);

        $bomCollection = BcDataTransformer::getBoms($jsonResponse);
        $routingCollection = BcDataTransformer::getRoutings($jsonResponse);
        $itemsCollection = BcDataTransformer::getItems($jsonResponse);

        $bcItemService
            ->truncateBcBoms()
            ->createBoms($bomCollection)
            ->truncateBcRoutings()
            ->createRoutings($routingCollection)
            ->truncateItems()
            ->createItems($itemsCollection);

        $endTime = time();

        Log::driver('bc')->info('Execution Time: ' . CarbonInterval::seconds($endTime - $startTime)->forHumans());
    }
}
