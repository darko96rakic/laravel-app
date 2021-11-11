<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MostPopularVideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'countryName' => $this['countryName'],
           'foreword' => $this['foreword'],
           'videos' => YouTubeVideoResource::collection($this['videos'])
        ];
    }
}
