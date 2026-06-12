<?php

namespace App\Services\Contracts;
use Illuminate\Support\Collection;

interface BookServiceInterface extends ServiceInterface
{
    public function getList(): Collection;

    public function getCreateFormData(): array;

    public function create(array $data, $coverImage = null): \Illuminate\Database\Eloquent\Model;

    public function getBookDetail(int $id): \Illuminate\Database\Eloquent\Model;
}
