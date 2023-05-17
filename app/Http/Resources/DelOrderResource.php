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
        'id' => $this->id,
         'status' => $this->status,
         'payment' => $this->payment_method,
         'date'=> Carbon::parse($this->created_at)->format('Y-m-d  h:i a'),
         'address' => $this->address->title,
         'client_name' => $this->client->name,
         'delivery_name'=>$this->delivery->name,
        ];

    }
}
