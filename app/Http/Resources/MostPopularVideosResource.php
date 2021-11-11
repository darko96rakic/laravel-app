<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MostPopularVideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'countryName' => $this['countryName'],
            'foreword' => $this['foreword'],
            'videos' => YouTubeVideoResource::collection($this['videos'])
        ];
    }
}
