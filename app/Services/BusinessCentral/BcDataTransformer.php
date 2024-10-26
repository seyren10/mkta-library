<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\DTOs\BcJsonData;
use App\Services\ItemService;
use App\Services\MaterialService;
use App\Services\WorkCentersService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BcDataTransformer
{

    public static function getWorkCenters(BcJsonData $jsonData): Collection
    {
        return $jsonData
            ->values()
            ->map(function (array $value) {
                return [
                    'name' => $value['Name'],
                    'abbr' => $value['No']
                ];
            });
    }

    public static function getItems(BcJsonData $jsonData): Collection
    {
        return $jsonData
            ->values()
            ->filter(function ($value) {
                return !empty($value['No']);
            })
            ->map(function ($value) {
                return [
                    'code' => $value['No'],
                    'description' => $value['Description'],
                    'prod_materials' => $value['Gen_Prod_Posting_Group'],
                    'routing_no' => !empty($value['Routing_No']) ?  $value['Routing_No'] : null,
                    'production_bom_no' => !empty($value['Production_BOM_No']) ? $value['Production_BOM_No'] : null,
                    'parent_code' => !empty($value['Routing_No']) ? $value['Routing_No'] : $value['No']
                ];
            });
    }

    public static function getItemDimensions(BcJsonData  $jsonData): Collection
    {
        $itemCodes = ItemService::getItemCodes();

        return $jsonData
            ->values()
            ->filter(function ($value) use ($itemCodes) {
                return $itemCodes->contains($value['Item_No']);
            })
            ->map(function ($value) {
                return [
                    'item_code' => $value['Item_No'],
                    'length' => $value['Length'],
                    'width' => $value['Width'],
                    'height' => $value['Height'],
                    'sqm' => $value['Cubage'],
                    's_weight' => $value['Weight']
                ];
            });
    }

    public static function getBoms(BcJsonData $jsonData): Collection
    {
        return $jsonData
            ->values()
            ->pluck('Production_BOM_No')
            ->filter()
            ->unique()
            ->map(function ($value) {
                return ['production_bom_no' => $value];
            });
    }

    public static function getRoutings(BcJsonData $jsonData): Collection
    {
        return $jsonData
            ->values()
            ->pluck('Routing_No')
            ->filter()
            ->unique()
            ->map(function ($value) {
                return ['routing_no' => $value];
            });
    }

    public static function getMaterials(BcJsonData $jsonData): Collection
    {
        return $jsonData
            ->values()
            ->map(function ($value) {
                return [
                    'code' => $value['No'],
                    'name' => $value['Description']
                ];
            });
    }

    public static function getItemBom(BcJsonData $jsonData): Collection
    {
        $bomCodes = BcBomService::getBomCodes();
        $materialCodes = MaterialService::getMaterialCodes();
        $workCenterAbbrs = WorkCentersService::getAbbrs();

        return $jsonData
            ->values()
            ->filter(function ($item) use ($bomCodes, $materialCodes, $workCenterAbbrs) {
                return $bomCodes->contains($item['Production_BOM_No']) &&
                    $materialCodes->contains($item['No']) &&
                    $workCenterAbbrs->contains($item['Routing_Link_Code']);
            })->map(function ($value) {
                return [
                    'quantity' => $value['Quantity_per'],
                    'uom' => $value['Unit_of_Measure_Code'],
                    'production_bom_no' => $value['Production_BOM_No'],
                    'material_code' => $value['No'],
                    'work_center_abbr' => $value['Routing_Link_Code']
                ];
            });
    }

    public static function getItemRoutingsJson(BcJsonData $jsonData)
    {

        return static::getItemRoutings($jsonData->values());
    }

    public static function getItemRoutings(Collection $items): Collection
    {
        $routingNos = BcRoutingService::getRoutingNo();
        $workCenterAbbrs = WorkCentersService::getAbbrs();

        $newItems =   $items
            ->filter(function ($value) use ($routingNos, $workCenterAbbrs) {
                return
                    !is_numeric($value['Operation_No']) &&
                    $routingNos->contains($value['Routing_No']) &&
                    $workCenterAbbrs->contains($value['Routing_Link_Code']);
            })
            ->groupBy('Routing_No')
            ->map(function (Collection $items) {
                $occurrenceCounts = [];

                return $items
                    ->sortBy('Operation_No')
                    ->map(function ($item, $index) use (&$occurrenceCounts) {

                        $linkCode = $item['Routing_Link_Code'];

                        // Increment occurrence count for this Routing_Link_Code
                        if (!isset($occurrenceCounts[$linkCode])) {
                            $occurrenceCounts[$linkCode] = 0;
                        }
                        $occurrenceCounts[$linkCode]++;

                        return [
                            'routing_no' => $item['Routing_No'],
                            'work_center_abbr' => $item['Routing_Link_Code'],
                            'manpower' => $item['Concurrent_Capacities'],
                            'runtime' => $item['Run_Time'],
                            'sequence_index' => $index,
                            'process_index' => $occurrenceCounts[$linkCode]
                        ];
                    })
                    ->values(); // Re-indexes the collection after sorting
            })
            ->flatten(1);

        return $newItems;
    }
}
