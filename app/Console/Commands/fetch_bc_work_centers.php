<?php

namespace App\Console\Commands;

use App\Enums\BcContext;
use App\Services\BusinessCentral\BcDataTransformer;
use App\Services\BusinessCentral\BcWorkCenterService;
use App\Services\BusinessCentral\BusinessCentralHttpClient;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;

class fetch_bc_work_centers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:fetch_bc_work_centers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        BusinessCentralHttpClient $client,
        BcWorkCenterService $bcWorkCenterService,
    ) {
        $startTime = time();

        $jsonResponse = $client->getByContext(BcContext::WorkCenters);
        $workCentersCollection = BcDataTransformer::getWorkCenters($jsonResponse);
        $bcWorkCenterService
            ->truncate()
            ->createWorkCenters($workCentersCollection);


        while ($jsonResponse->hasNextLink()) {
            $nextJsonResponse = $client->getByContext($jsonResponse->getNextLink());
            $nextWorkCentersCollection = BcDataTransformer::getWorkCenters($nextJsonResponse);
            $bcWorkCenterService->createWorkCenters($nextWorkCentersCollection);
        }

        $endTime = time();

        info('Execution Time: ' . CarbonInterval::seconds($endTime - $startTime)->forHumans());
    }
}
