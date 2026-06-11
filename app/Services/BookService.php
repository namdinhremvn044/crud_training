<?php

namespace App\Services;

use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Support\Collection;

class BookService extends BaseService implements BookServiceInterface
{
    public function __construct(BookRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getList(): Collection
    {
        return $this->all()->load(['author', 'categories'])->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author?->name,
                'categories' => $book->categories->pluck('name')->toArray(),
                'price' => $book->price,
                'publish_date' => $book->publish_date,
                'status' => $book->status,
            ];
        });
    }
}
