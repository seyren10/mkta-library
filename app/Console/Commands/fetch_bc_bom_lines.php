<?php

namespace App\Console\Commands;

use App\Enums\BcContext;
use App\Services\BusinessCentral\BcDataTransformer;
use App\Services\BusinessCentral\BcItemBomService;
use App\Services\BusinessCentral\BusinessCentralHttpClient;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;


class fetch_bc_bom_lines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_bc_bom_lines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch item bill of materials on business central (!important!: items table should be populated first.)';

    /**
     * Execute the console command.
     */
    public function handle(
        BusinessCentralHttpClient $client,
        BcItemBomService $itemBomService
    ) {
        $startTime = time();

        $client->setParams(['$filter' => 'Quantity_per gt 0.0']);
        $jsonResponse = $client->getByContext(BcContext::BOMLines);
        $itemBomCollection = BcDataTransformer::getItemBom($jsonResponse);

        $itemBomService
            ->truncate()
            ->createItemBoms($itemBomCollection);

        while ($jsonResponse->hasNextLink()) {
            if ($query = $jsonResponse->getNextLinkQuery()) {
                $client->setParams($query);
            }

            $jsonResponse = $client->get($jsonResponse->getNextLinkUrl());

            $itemBomCollection = BcDataTransformer::getItemBom($jsonResponse);

            $itemBomService->createItemBoms($itemBomCollection);
        }

        $endTime = time();
        
        info('Execution Time: ' . CarbonInterval::seconds($endTime - $startTime)->forHumans());
    }
}
