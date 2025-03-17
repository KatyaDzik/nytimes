<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this['title'] ?? '',
            'description' => $this['description'] ?? '',
            'contributor' => $this['contributor'] ?? '',
            'author' => $this['author'] ?? '',
            'price' => $this['price'] ?? '',
            'publisher' => $this->publisher ?? '',
            'isbns' => IsbnResource::collection($this['isbns'] ?? []),
            'ranks_history' => RankHistoryResource::collection($this['ranks_history'] ?? []),
            'reviews' => ReviewResource::collection($this['reviews'] ?? []),
        ];
    }
}
