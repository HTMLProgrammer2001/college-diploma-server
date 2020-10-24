<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'authors' => $this->getAuthorsString(),
            'title' => $this->title,
            'description' => $this->description,
            'date_of_publication' => $this->date_of_publication,
            'publisher' => $this->publisher,
            'url' => $this->url
        ];
    }
}
