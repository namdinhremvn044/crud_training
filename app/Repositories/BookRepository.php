<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function createWithCategories(array $attributes, array $categoryIds): Book
    {
        $book = $this->model->newQuery()->create($attributes);
        $book->categories()->sync($categoryIds);

        return $book->fresh(['author', 'categories']);
    }
}
