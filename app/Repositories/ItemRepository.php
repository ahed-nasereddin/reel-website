<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Collection;

class ItemRepository
{
    public function findById(int $id): ?Item
    {
        return Item::with(['brand', 'subCategory'])->find($id);
    }

    public function findByIds(array $ids): Collection
    {
        return Item::with(['brand', 'subCategory'])->whereIn('id', $ids)->get();
    }
}
