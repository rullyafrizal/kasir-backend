<?php

namespace App\Http\Resources\TransactionItem;

use App\Enums\DateFormat;
use App\Http\Resources\Item\ItemResource;
use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionItemResource extends JsonResource
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
            'quantity' => $this->quantity,
            'subtotal' => $this->subtotal,
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
            'item' => new ItemResource($this->whenLoaded('item')),
            'created_at' => $this->created_at->format(DateFormat::WITH_TIME),
            'updated_at' => $this->updated_at->format(DateFormat::WITH_TIME),
        ];
    }
}
