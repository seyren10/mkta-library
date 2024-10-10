<?php

return [
    'links' => [
        'work_centers' => env('BC_API_LINK_WORK_CENTERS'),
        'routing_lines' => env('BC_API_LINK_ROUTING_LINES'),
        'bom_lines' => env('BC_API_LINK_BOM_LINES'),
        'dimensions' => env('BC_API_LINK_DIMENSIONS'),
        'item_list' => env('BC_API_LINK_ITEM_LIST') . '?' .  http_build_query(['$filter' => "Replenishment_System eq 'Prod. Order'"]),
        'materials' => env('BC_API_LINK_ITEM_LIST') . '?' .  http_build_query(['$filter' => "Replenishment_System eq 'Purchase'"]),
    ],

    'client_id' => env('BC_API_CLIENT_ID'),
    'client_secret' => env('BC_API_CLIENT_SECRET'),
    'token_url' => env('BC_API_ACCESS_TOKEN_URL'),
    'scope' => env('BC_API_SCOPE'),
    'grant_type' => 'client_credentials'
];
