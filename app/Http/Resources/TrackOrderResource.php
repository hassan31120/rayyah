<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackOrderResource extends JsonResource
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
            'delivery' => $this->delivery->name ?? null,
            'service_price' => number_format($this->total_service_price),
            'delivery_price' => number_format($this->total_del_price),
            'total_price' => number_format($this->total_cost),
            'reference_number' => $this->ref_number,
            'service' => $this->service->name ?? null,
            'description' => $this->description,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'date' => $this->created_at,
            'user' => new UserResource($this->client),
            'address' => new AddressResource($this->address)
        ];
    }
}
