<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Resources\Item\ItemCollection;
use App\Http\Resources\Item\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search']);

        $items = new ItemCollection(
            Item::query()
                ->filters($filters)
                ->paginate(10)
        );

        return api_response(
            [
                'items' => $items->response()->getData()
            ],
            'get:items:success',
            200
        );
    }

    public function store(StoreItemRequest $request)
    {
        Item::query()
            ->create($request->validated());

        return api_response(
            [],
            'store:item:success',
            201
        );
    }

    public function show(Item $item)
    {
        return api_response(
            [
                'item' => new ItemResource($item)
            ],
            'get:item:success',
            200
        );
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->validated());

        return api_response(
            [],
            'update:item:success',
            200
        );
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return api_response(
            [],
            'delete:item:success',
            200
        );
    }
}
