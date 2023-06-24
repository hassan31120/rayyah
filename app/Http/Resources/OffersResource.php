<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OffersResource extends JsonResource
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
            'order_id' => $this->order_id,
            'delivery' => $this->delivery->name,
            'delivery_image' => $this->when(true, function () {
                if (isset($this->attachmentRelation[0])) {
                    return asset($this->attachmentRelation[0]->path);
                } else {
                    return null;
                }
            }),
            'country_code' => $this->delivery->country_code,
            'phone' => $this->delivery->number,
            'time' => $this->est_time,
            'price' => $this->price,
            'order' => new TrackOrderResource($this->order)
        ];
    }
}
