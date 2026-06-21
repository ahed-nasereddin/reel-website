<?php

namespace App\Http\Controllers\Api;

use App\DTOs\QuotationDTO;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\QuotationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuotationController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected QuotationService $quotationService,
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'no_days' => 'required|integer|min:1',
            'pickup_date' => 'required|date',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|integer|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $normalizedItems = $this->cartService->validateCartPayload(['items' => $validated['items']]);

        $quotationDTO = new QuotationDTO([
            'name' => $validated['name'],
            'company_name' => $validated['company_name'] ?? null,
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'no_days' => $validated['no_days'],
            'pickup_date' => $validated['pickup_date'],
            'location' => $validated['location'],
            'notes' => $validated['notes'] ?? null,
            'equipments' => $normalizedItems,
        ]);

        $quotation = $this->quotationService->createQuotation($quotationDTO);

        $request->session()->forget('cart.items');

        return response()->json([
            'message' => 'Quotation created successfully!',
            'data' => $quotation,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $quotation = $this->quotationService->findQuotation($id);

        if (! $quotation) {
            return response()->json(['message' => 'Quotation not found.'], 404);
        }

        return response()->json(['data' => $quotation]);
    }
}
