<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function createTransaction(array $request)
    {
        DB::transaction(function () use ($request) {
            $transaction = Transaction::query()
                ->create([
                    'user_id' => auth()->id(),
                    'total_price' => $request['total_price'],
                    'paid' => $request['paid'],
                    'change' => $request['change'],
                ]);

            foreach ($request['transaction_items'] as $item) {
                $transaction->transactionItems()->create([
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        });
    }

    public function updateTransaction(Transaction $transaction, array $request)
    {
        DB::transaction(function () use ($transaction, $request) {
            $transaction->transactionItems()->delete();

            $transaction->update([
                'total_price' => $request['total_price'],
                'paid' => $request['paid'],
                'change' => $request['change'],
            ]);

            foreach ($request['transaction_items'] as $item) {
                $transaction->transactionItems()->create([
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        });
    }

    public function deleteTransaction(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            $transaction->transactionItems()->delete();
            $transaction->delete();
        });
    }
}
