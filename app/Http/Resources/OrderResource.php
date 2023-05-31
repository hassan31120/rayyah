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
            'total_del_price' => $this->total_del_price,
            'total_service_price' => $this->total_service_price,
            'total_price' => $this->total_cost,
            'time' => $this->created_at,
            'status' => $this->status,
            'service' => $this->service->name ?? null,
            'delivery' => new UserResource($this->delivery)
        ];
    }
}
