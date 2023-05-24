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
            'total_price'=> $this->total_cost ,
            'time'=> Carbon::parse($this->created_at)->format('h:i a'),
            'status'=>$this->status,
            'service'=>$this->service->name ?? null


        ];
    }
}
