<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $items = $request->session()->get('cart.items', []);

        return response()->json($this->cartService->formatCartResponse($items));
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $item = $this->cartService->normalizeItemPayload($validated);
        $cart = $request->session()->get('cart.items', []);

        $existingIndex = array_search($item->item_id, array_column($cart, 'item_id'), true);

        if ($existingIndex !== false) {
            $cart[$existingIndex]['quantity'] += $item->quantity;
        } else {
            $cart[] = $item->toArray();
        }

        $request->session()->put('cart.items', $cart);

        return response()->json($this->cartService->formatCartResponse($cart));
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart.items', []);
        $existingIndex = array_search($validated['item_id'], array_column($cart, 'item_id'), true);

        if ($existingIndex === false) {
            abort(404, 'Cart item not found.');
        }

        $cart[$existingIndex]['quantity'] = $validated['quantity'];
        $request->session()->put('cart.items', $cart);

        return response()->json($this->cartService->formatCartResponse($cart));
    }

    public function remove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,id',
        ]);

        $cart = $request->session()->get('cart.items', []);
        $cart = array_filter($cart, fn ($item) => $item['item_id'] !== $validated['item_id']);
        $request->session()->put('cart.items', array_values($cart));

        return response()->json($this->cartService->formatCartResponse($cart));
    }
}
