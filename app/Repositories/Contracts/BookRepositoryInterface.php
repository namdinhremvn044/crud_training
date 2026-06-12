<?php

namespace App\Repositories\Contracts;

interface BookRepositoryInterface extends RepositoryInterface
{
    public function createWithCategories(array $attributes, array $categoryIds): \Illuminate\Database\Eloquent\Model;
}
