<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\DTOs\BcJsonData;
use App\Enums\BcContext;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class BusinessCentralHttpClient
{
    private Client $client;
    private array $options;

    public function __construct(BusinessCentralApiToken $apiToken)
    {
        $this->client = new Client();

        $token = $apiToken->token();

        $this->options = [
            'headers' => [
                'Authorization' => "Bearer {$token}",
                'Accept-Encoding' => 'gzip, deflate'
            ],
        ];
    }

    public function setHeaders(array $headers): static
    {
        $this->options['headers'] = $headers;

        return $this;
    }

    public function setParams(array $params): static
    {
        $this->options['query'] = $params;

        return $this;
    }

    public function get(string $link): BcJsonData
    {
        try {
            info('Getting Data from: ' . $link);
            $response = $this->client->get($link, $this->options);
        } catch (Exception $e) {
            Log::error($e->getMessage() . $e->getCode());
        }


        return new BcJsonData($response);
    }

    public function getByContext(BcContext $context): BcJsonData
    {
        $contextLink = $context->getContextLink();

        return  $this->get($contextLink);
    }

}
