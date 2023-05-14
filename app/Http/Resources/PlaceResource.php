<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
           'description' => $this->description,
           'logo' => $this->attachmentRelation[0]->path,
           'image'=>$this->productImages[0]->image,
           'distance' => $this->distance,
           'rate'=>$this->rate
        ];
    }
}
