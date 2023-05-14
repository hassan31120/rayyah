<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'my-blance'=>$this->balance,
            'transs'=>$this->user->trans->map(function($item , $key){
                return [
                    'amount'=>$item->balance,
                    'sender'=>$item->sender->number
                ];
            })
        ];
    }
}
