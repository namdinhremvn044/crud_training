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
}
