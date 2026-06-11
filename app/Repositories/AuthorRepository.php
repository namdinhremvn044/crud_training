<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    public function __construct(Author $model)
    {
        parent::__construct($model);
    }
}
