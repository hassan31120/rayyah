<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'discount' => $this->discount,
            'owner' => $this->owner,
            'owner_ratio' => $this->owner_ratio,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'maximum_usage' => $this->maximum_usage,
            'current_usage' => $this->getCurrentUsageCount(),
            'remaining_usage' => $this->getRemainingUsageCount(),
        ];
    }
}
