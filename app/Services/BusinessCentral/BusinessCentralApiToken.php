<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BusinessCentralApiToken
{

    private ?array $accessToken;
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $accessTokenUrl,
        private readonly string $scope,
        private readonly string $grantType,
    ) {
        $this->accessToken = null;
        $this->getToken();
    }

    private function getToken(): array
    {
        Log::driver('bc')->info('getting token');

        $client = new Client();

        $response = $client->post($this->accessTokenUrl, [
            'form_params' => [
                'grant_type' => $this->grantType,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => $this->scope,
            ],
        ]);
        
        /* refresh the token if response is invalid */
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() <= 499) {
            $this->getToken();
        }

        $this->accessToken =  json_decode((string) $response->getBody(), true);
        return $this->accessToken;
    }

    public function token(): string
    {
        return $this->accessToken['access_token'];
    }
}
