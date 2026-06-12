<?php

namespace App\Repositories\Contracts;

interface BookRepositoryInterface extends RepositoryInterface
{
    public function createWithCategories(array $attributes, array $categoryIds): \Illuminate\Database\Eloquent\Model;

    public function getBookDetail(int $id): \Illuminate\Database\Eloquent\Model;
}
