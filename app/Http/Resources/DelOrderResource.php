<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id ?? null,
         'status' => $this->status,
         'payment' => $this->payment_method,
         'date'=> $this->created_at,
         'address' => $this->address->title,
         'client_name' => $this->client->name,
         'delivery_name'=>$this->delivery->name,
         'description' => $this->description,
         'service_price'=>$this->total_service_price,
         'delivery_price'=>$this->total_del_price,
         'total_price'=>$this->total_cost,
     ];

    }
}
