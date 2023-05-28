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
            'id'=>$this->id,
            'delivery' => $this->delivery->name ?? null,
            'service_price'=>number_format($this->total_service_price),
            'delivery_price'=>number_format($this->total_del_price),
            'total_price'=>number_format($this->total_cost),
            'reference number'=> $this->ref_number,
            'service'=>$this->service->name ?? null,
            'address'=>$this->address->title,
            'description'=>$this->description,
            'status'=>$this->status,
            'payment_method'=>$this->payment_method,
            'date'=>$this->created_at,
            'user'=>$this->client->name,
            'user_image'=>asset($this->client->attachmentRelation[0]->path),
            'phone'=>$this->client->number,

           


        ];
    }
}
