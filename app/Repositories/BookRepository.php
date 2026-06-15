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

    public function getBookDetail(int $id): Book
    {
        return $this->model->newQuery()
            ->with(['author', 'categories'])
            ->findOrFail($id);
    }

    public function updateWithCategories(int $id, array $attributes, array $categoryIds): Book
    {
        $book = $this->model->newQuery()->findOrFail($id);
        $book->update($attributes);
        $book->categories()->sync($categoryIds);

        return $book->fresh(['author', 'categories']);
    }
}
