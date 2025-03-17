<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'primary_isbn10' => $this['primary_isbn10'] ?? '',
            'primary_isbn13' => $this['primary_isbn13'] ?? '',
            'rank' => $this['rank'] ?? '',
            'list_name' => $this['list_name'] ?? '',
            'display_name' => $this['display_name'] ?? '',
            'published_date' => $this['published_date'] ?? '',
            'weeks_on_list' => $this['weeks_on_list'] ?? 0,
        ];
    }
}
