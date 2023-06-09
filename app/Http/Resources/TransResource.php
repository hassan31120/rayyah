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
            'my-blance' => $this->balance,
            'sending_trans' => $this->user->sending_trans->map(function ($item, $key) {
                return [
                    'amount' => $item->value,
                    'sender_country_code' => $item->sender->country_code,
                    'sender' => $item->sender->number,
                    'reciver_country_code' => $item->reciver->country_code,
                    'reciver' => $item->reciver->number,
                    'created_at' => $item->created_at
                ];
            }),
            'reciving_trans' => $this->user->reciving_trans->map(function ($item, $key) {
                return [
                    'amount' => $item->value,
                    'sender_country_code' => $item->sender->country_code,
                    'sender' => $item->sender->number,
                    'reciver_country_code' => $item->reciver->country_code,
                    'reciver' => $item->reciver->number,
                    'created_at' => $item->created_at
                ];
            })
        ];
    }
}
