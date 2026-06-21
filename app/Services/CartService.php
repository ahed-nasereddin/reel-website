<?php

namespace App\Services;

use App\DTOs\CartItemDTO;
use App\Repositories\ItemRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CartService
{
    public function __construct(protected ItemRepository $itemRepository)
    {
    }

    public function normalizeItemPayload(array $payload): CartItemDTO
    {
        $item = $this->itemRepository->findById((int) ($payload['item_id'] ?? $payload['id'] ?? 0));

        if (! $item) {
            abort(404, 'Equipment not found.');
        }

        return new CartItemDTO([
            'item_id' => $item->id,
            'name' => $item->name,
            'brand' => $item->brand?->name,
            'image' => $item->main_image ? asset('storage/' . $item->main_image) : null,
            'quantity' => max(1, (int) ($payload['quantity'] ?? $payload['count'] ?? 1)),
            'url' => url('/items/' . $item->slug),
        ]);
    }

    public function normalizeCart(array $items): array
    {
        return array_map(fn ($item) => $this->normalizeItemPayload((array) $item)->toArray(), $items);
    }

    public function calculateTotals(array $cartItems): array
    {
        $totalQuantity = array_sum(array_column($cartItems, 'quantity'));
        $uniqueItems = count($cartItems);

        return [
            'total_items' => $uniqueItems,
            'total_quantity' => $totalQuantity,
        ];
    }

    public function validateCartPayload(array $payload): array
    {
        if (! isset($payload['items']) || ! is_array($payload['items'])) {
            abort(422, 'Cart items are required.');
        }

        return $this->normalizeCart($payload['items']);
    }

    public function formatCartResponse(array $items): array
    {
        $normalized = $this->normalizeCart($items);

        return [
            'items' => $normalized,
            'meta' => $this->calculateTotals($normalized),
        ];
    }
}
