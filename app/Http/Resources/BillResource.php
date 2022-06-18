<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'time_limit' => $this->time_limit,
            'discount' => $this->discount,
            'paid' => $this->paid,
            'sessions' => SessionResource::collection($this->sessions),
            'temp_items' => BillItemResource::collection($this->tempItems),
        ];
    }
}
