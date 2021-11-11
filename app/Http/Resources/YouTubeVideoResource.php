<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YouTubeVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'description' => $this['snippet']['description'],
            'thumbnails' => [
                'normal' => $this['snippet']['thumbnails']['default']['url'],
                'high' => $this['snippet']['thumbnails']['high']['url']
            ]
        ];
    }
}
