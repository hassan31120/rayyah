<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceByCatResource extends JsonResource
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
                    'rate' => $this->rate,
                    'image' => $this->productImages[0]->image,
                    'logo'=>$this->attachmentRelation[0]->path,
                    'distance'=>$this->distance,
                   
            
        ];
    }
}
