<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillItemResource extends JsonResource
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
            'bill_id' => $this->bill_id,
            'item_id' => $this->item->id,
            'item_name' => $this->item->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}
