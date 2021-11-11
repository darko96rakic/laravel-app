<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YouTubeVideoResource extends JsonResource
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
            'description' => $this['snippet']['description'],
            'thumbnails' => [
                'normal' => $this['snippet']['thumbnails']['default']['url'],
                'high' => $this['snippet']['thumbnails']['high']['url']
            ]
        ];
    }
}
