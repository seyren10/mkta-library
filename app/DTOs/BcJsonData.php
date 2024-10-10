<?php

declare(strict_types=1);

namespace App\DTOs;

use Generator;
use Illuminate\Database\Eloquent\Collection;
use Psr\Http\Message\ResponseInterface;

class BcJsonData
{

    private array $jsonData;
    public function __construct(private ResponseInterface $response)
    {
        $this->jsonData = json_decode($response->getBody()->getContents(), true);
    }

    public function values()
    {
        return new Collection($this->jsonData['value']);
    }

    public function chunkValues(int $size = 1000): Generator
    {
        $chunks = $this->values()->chunk($size);

        foreach ($chunks as $chunk) {
            yield $chunk;
        }
    }

    public function getNextLink()
    {
        return $this->jsonData['@odata.nextLink'];
    }

    public function hasNextLink()
    {

        return isset($this->jsonData['@odata.nextLink']);
    }

    public function getNextLinkUrl(): string|null
    {
        if (!$this->hasNextLink())
            return null;


        ['scheme' => $scheme, 'host' => $host, 'path' => $path] = parse_url($this->getNextLink());

        return     $scheme . '://' . $host . $path;
    }

    public function getNextLinkQuery(): array|null
    {
        if (!$this->hasNextLink())
            return null;

        ['query' => $query] = parse_url($this->getNextLink());

        parse_str($query, $output);
        return $output;
    }
}
