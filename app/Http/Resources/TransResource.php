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
            'sending_trans'=>$this->user->send_trans->map(function ($item , $key){
                return[
                    'amount' => $item->value,
                    'sender' => $item->sender->number,
                    'reciver' => $item->reciver->number


                ];
            }),

            'recieving_trans'=>$this->user->recieve_trans->map(function ($item , $key){
                return[
                    'amount' => $item->value,
                    'sender' => $item->sender->number,
                    'reciver' => $item->reciver->number



                ];
            }),

        ];
    }
}
