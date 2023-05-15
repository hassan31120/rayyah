<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'number'    => $this->number,
            'userType'  => $this->userType,
            'balance'   => (double) $this->wallet->balance,
            'image'     => $this->when(true, function () {
                if (isset($this->attachmentRelation[0])) {
                    return asset($this->attachmentRelation[0]->path);
                } else {
                    return null;
                }
            }),
        ];
    }
}
