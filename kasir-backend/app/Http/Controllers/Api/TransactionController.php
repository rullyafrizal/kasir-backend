<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Services\TransactionService;
use function api_response;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = new TransactionCollection(
            Transaction::query()
                ->paginate(10)
        );

        return api_response(
            [
                'transactions' => $transactions->response()->getData()
            ],
            'get:transactions:success',
            200
        );
    }

    public function show(Transaction $transaction)
    {
        return api_response(
            [
                'transaction' => new TransactionResource(
                    $transaction->load(['transactionItems' => function ($query) {
                        $query->with('item');
                    }])
                )
            ],
            'get:transaction:success',
            200
        );
    }

    public function store(StoreTransactionRequest $request)
    {
        $this->transactionService->createTransaction($request->validated());

        return api_response(
            null,
            'create:transaction:success',
            201
        );
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $this->transactionService->updateTransaction($transaction, $request->validated());

        return api_response(
            null,
            'update:transaction:success',
            200
        );
    }

    public function destroy(Transaction $transaction)
    {
        $this->transactionService->deleteTransaction($transaction);

        return api_response(
            null,
            'delete:transaction:success',
            200
        );
    }
}
