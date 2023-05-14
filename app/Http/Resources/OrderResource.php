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
            'order_number'=>$this->id,
            'address'=>$this->address->title,
            'total_price'=> $this->total_price ?? null,
            'time'=> Carbon::parse($this->created_at)->format('h:i a'),
            'status'=>$this->status,    
            'items'=>$this->items->map(function($item, $key){
                return [
                    'image'=>$item->product->attachmentRelation[0]->path,
                    'name'=>$item->product->name
                ];
            })


        ];
    }
}
