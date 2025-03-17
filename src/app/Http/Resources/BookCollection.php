<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this['status'] ?? '',
            'copyright' => $this['copyright'] ?? '',
            'num_results' => $this['num_results'] ?? 0,
            'results' => BookResource::collection($this['results'] ?? []),
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
