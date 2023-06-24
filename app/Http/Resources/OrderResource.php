<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_number' => $this->id,
            'address' => $this->address->title,
            'address_description' => $this->address->description,
            'description' => $this->description,
            'reference_number' => $this->ref_number,
            'total_del_price' => $this->total_del_price,
            'time' => $this->created_at,
            'est_time' => $this->est_time,
            'status' => $this->status,
            'service' => $this->service->name ?? null,
            'delivery' => new UserResource($this->delivery)
        ];
    }
}
