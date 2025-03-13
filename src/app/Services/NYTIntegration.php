<?php

namespace App\Services;

use App\DTO\NYTDtoParam;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NYTIntegration
{
    public function __construct(
        protected string $apiKey,
        protected string $apiUrl
    ) {
    }

    public function fetchBestSellers(NYTDtoParam $dtoParam): ?array
    {
        $queryParams['api-key'] = $this->apiKey;

        $queryParams = array_filter([
            'api-key' => $this->apiKey,
            'author' => $dtoParam->getAuthor(),
            'isbn' => $dtoParam->getIsbn(),
            'title' => $dtoParam->getTitle(),
            'offset' => $dtoParam->getOffset(),
        ]);

        $cacheKey = 'api_response_' . md5(json_encode($queryParams));

        $responseData = Cache::remember($cacheKey, now()->addDay(), function () use ($queryParams) {
            $response = Http::get($this->apiUrl, $queryParams);

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        });

        return $responseData;
    }
}
