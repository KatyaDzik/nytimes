<?php

namespace App\DTO;

class NYTDtoParam
{
    public function __construct(
        private ?string $author = null,
        private ?int $isbn = null,
        private ?string $title = null,
        private ?int $offset = null,
    ) {
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
}
