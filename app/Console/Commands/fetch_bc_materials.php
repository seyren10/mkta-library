<?php

namespace App\Console\Commands;

use App\Enums\BcContext;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use App\Services\BusinessCentral\BcDataTransformer;
use App\Services\BusinessCentral\BcMaterialsService;
use App\Services\BusinessCentral\BusinessCentralHttpClient;

class fetch_bc_materials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_bc_materials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch business central materials data';

    /**
     * Execute the console command.
     */
    public function handle(
        BusinessCentralHttpClient $client,
        BcMaterialsService $materialsService
    ) {

        $startTime = time();

        $jsonResponse = $client->getByContext(BcContext::Materials);

        $materialCollection = BcDataTransformer::getMaterials($jsonResponse);
        $materialsService
            ->truncate()
            ->createMaterials($materialCollection);

        while ($jsonResponse->hasNextLink()) {
            $jsonResponse = $client->get($jsonResponse->getNextLink());
            $nextMaterialCollection = BcDataTransformer::getMaterials($jsonResponse);
            $materialsService->createMaterials($nextMaterialCollection);
        }

        $endTime = time();
        info('Execution Time: ' . CarbonInterval::seconds($endTime - $startTime)->forHumans());
    }
}
