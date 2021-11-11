<?php

namespace App\Services;

use App\Services\Interfaces\ApiResponseServiceInterface;
use Illuminate\Support\Facades\Cache;

class ApiResponseCacheService implements ApiResponseServiceInterface
{
    /**
     * @var ApiResponseService
     */
    private ApiResponseService $apiResponseService;

    /**
     * @param ApiResponseService $apiResponseService
     */
    public function __construct(ApiResponseService $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }

    /**
     * @return array|null
     */
    public function fetchYouTubeResults(): ?array
    {
        return Cache::rememberForever(self::MOST_POPULAR_CACHE_KEY, function (){
           return $this->apiResponseService->fetchYouTubeResults();
        });
    }
}
