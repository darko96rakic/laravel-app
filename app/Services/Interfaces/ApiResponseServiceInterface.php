<?php

namespace App\Services\Interfaces;


interface ApiResponseServiceInterface {

    const MOST_POPULAR_CACHE_KEY = 'mostPopularVideos';

    public function fetchYouTubeResults(): ?array;
}
