<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'book_review_link' => $this['book_review_link'] ?? '',
            'first_chapter_link' => $this['first_chapter_link'] ?? '',
            'sunday_review_link' => $this['sunday_review_link'] ?? '',
            'article_chapter_link' => $this['article_chapter_link'] ?? '',
        ];
    }
}
