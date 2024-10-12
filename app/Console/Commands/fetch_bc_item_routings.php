<?php

namespace App\Console\Commands;

use App\Enums\BcContext;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Services\BusinessCentral\BcDataTransformer;
use App\Services\BusinessCentral\BcItemRoutingService;
use App\Services\BusinessCentral\BusinessCentralHttpClient;

class fetch_bc_item_routings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_bc_item_routings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch item routings on business central';

    /**
     * Execute the console command.
     */
    public function handle(BusinessCentralHttpClient $client, BcItemRoutingService $itemRoutingService)
    {
        $startTime = time();
        $client->setParams(
            ['$filter' => "Type eq 'Work Center' AND Routing_Link_Code ne '' AND Routing_Link_Code ne 'MIX'"]
        );

        $jsonResponse = $client->getByContext(BcContext::RoutingLines);

        $itemRoutingService
            ->truncate();
        // ->createItemRouting($itemRoutingChunkCollection);
        $data = $jsonResponse->values();

        while ($jsonResponse->hasNextLink()) {
            if ($query = $jsonResponse->getNextLinkQuery()) {
                $client->setParams($query);
            }

            $jsonResponse = $client->get($jsonResponse->getNextLinkUrl());

            $data = $data->mergeRecursive($jsonResponse->values());
        }

        $itemRoutingServiceCollection = BcDataTransformer::getItemRoutings($data);
        $itemRoutingService->createItemRouting($itemRoutingServiceCollection);

        $endTime = time();
        Log::driver('bc')->info('Execution Time: ' . CarbonInterval::seconds($endTime - $startTime)->forHumans());
    }
}
