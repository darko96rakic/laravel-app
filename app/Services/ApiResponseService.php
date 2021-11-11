<?php

namespace App\Services;

use App\Services\Interfaces\ApiResponseServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiResponseService implements ApiResponseServiceInterface
{
    const YOU_TUBE_API_URL = 'https://youtube.googleapis.com/youtube/v3/videos';
    const WIKIPEDIA_API_URL= 'https://en.wikipedia.org/w/api.php';

    /**
     * @return array
     */
    public function fetchYouTubeResults(): ?array
    {
        try {
            $countries = json_decode(Storage::disk('local')->get('countries.json'));

            $data = [];

            foreach ($countries as $country) {
                $mostPopularVideos = Http::get(self::YOU_TUBE_API_URL, [
                    'part' => 'snippet',
                    'chart' => 'mostPopular',
                    'key' => Config::get('app.youTubeApiKey'),
                    'regionCode' => $country->code,
                    'fields' => 'items/snippet/description, items/snippet/thumbnails'
                ]);

                $data[] = [
                    'countryName' => $country->name,
                    'foreword' => Cache::remember($country->name,1440, function () use ($country) {
                        return $this->fetchDescriptionFromWikipedia($country->name);
                    }),
                    'videos' => $mostPopularVideos['items']
                ];
            }

            return $data;

        }catch (\Exception $exception){
            Log::error($exception->getMessage());

            return null;
        }
    }

    /**
     * @param string $countryName
     *
     * @return string
     */
    private function fetchDescriptionFromWikipedia(string $countryName): string
    {
        $wikipedia = Http::get(self::WIKIPEDIA_API_URL,[
            'format' => 'json',
            'action' => 'query',
            'prop' => 'extracts',
            'exintro' => '',
            'explaintext' => '',
            'redirects' => 1,
            'titles' => $countryName
        ]);

        $wikipedia = $wikipedia['query']['pages'];
        $key = array_key_first($wikipedia);

        return $wikipedia[$key]['extract'];
    }
}
