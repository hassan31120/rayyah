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
            'delivery' => $this->delivery->name,
            'phone'=>$this->delivery->number,
            'time'=>$this->est_time,
            'price'=>$this->price

        ];
    }
}
