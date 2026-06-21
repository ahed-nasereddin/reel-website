<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CatalogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function __construct(protected CatalogService $catalogService)
    {
    }

    public function navigation(): JsonResponse
    {
        return response()->json([
            'data' => $this->catalogService->navigation(),
        ]);
    }

    public function mainCategories(): JsonResponse
    {
        return response()->json([
            'data' => $this->catalogService->mainCategories(),
        ]);
    }

    public function categories(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->catalogService->categories($request->all()),
        ]);
    }

    public function subCategories(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->catalogService->subCategories($request->all()),
        ]);
    }

    public function brands(): JsonResponse
    {
        return response()->json([
            'data' => $this->catalogService->brands(),
        ]);
    }

    public function items(Request $request): JsonResponse
    {
        return response()->json($this->catalogService->items($request->all()));
    }

    public function show(string $slug): JsonResponse
    {
        return response()->json($this->catalogService->itemDetails($slug));
    }

    public function relatedItems(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->catalogService->relatedItems($id),
        ]);
    }
}
