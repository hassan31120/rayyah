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
            'required_price'=>$this->total_service_price,
            'delivery_price'=>$this->total_del_price,
            'total_price'=>$this->total_cost,
            'reference number'=> $this->ref_number,
            'items'=>$this->items->map(function($item, $key){
                return [
                    'image'=>$item->product->attachmentRelation[0]->path,
                    'name'=>$item->product->name
                ];
            })


        ];
    }
}
