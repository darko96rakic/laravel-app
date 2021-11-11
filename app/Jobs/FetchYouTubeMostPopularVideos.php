<?php

namespace App\Jobs;

use App\Services\ApiResponseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;


class FetchYouTubeMostPopularVideos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $apiResponseService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ApiResponseService $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $data = $this->apiResponseService->fetchYouTubeResults();

       Cache::forever($this->apiResponseService::MOST_POPULAR_CACHE_KEY, $data);
    }
}
