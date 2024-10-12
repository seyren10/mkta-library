<?php

namespace App\Console\Commands;

use App\Enums\BcContext;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\BusinessCentral\BcDataTransformer;
use App\Services\BusinessCentral\BcItemDimensionService;
use App\Services\BusinessCentral\BusinessCentralHttpClient;

class fetch_bc_item_dimensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_bc_item_dimensions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch item dimensions on business central (!important!: items table should be populated first.)';

    /**
     * Execute the console command.
     */
    public function handle(
        BusinessCentralHttpClient $client,
        BcItemDimensionService $bcItemDimService
    ) {
        $startTime = time();

        $jsonResponse = $client->getByContext(BcContext::Dimensions);

        $itemMaterialCollection = BcDataTransformer::getItemDimensions($jsonResponse);
        $bcItemDimService
            ->truncate()
            ->createItemDimensions($itemMaterialCollection);

        while ($jsonResponse->hasNextLink()) {
            $jsonResponse = $client->get($jsonResponse->getNextLink());
            $itemMaterialCollection = BcDataTransformer::getItemDimensions($jsonResponse);
            $bcItemDimService->createItemDimensions($itemMaterialCollection);
        }

        $endTime = time();

        Log::driver('bc')->info('Execution Time: ' . CarbonInterval::seconds($endTime - $startTime)->forHumans());
    }
}
