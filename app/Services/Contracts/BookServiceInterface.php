<?php

namespace App\Services\Contracts;
use Illuminate\Support\Collection;

interface BookServiceInterface extends ServiceInterface
{
    public function getList(): Collection;
}
