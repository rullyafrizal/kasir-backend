<?php

namespace App\Http\Resources\Transaction;

use App\Enums\DateFormat;
use App\Http\Resources\TransactionItem\TransactionItemCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'total_price' => $this->total_price,
            'paid' => $this->paid,
            'change' => $this->change,
            'user' => new UserResource($this->whenLoaded('user')),
            'transaction_items' => new TransactionItemCollection($this->whenLoaded('transactionItems')),
            'created_at' => $this->created_at->format(DateFormat::WITH_TIME),
            'updated_at' => $this->updated_at->format(DateFormat::WITH_TIME),
        ];
    }
}
