<?php

namespace App\Repository\Contracts;

use App\ViewModels\TodoVM;
use App\Models\Todo as ModelsTodo;
use App\ViewModels\Request\TodoPaginationRequest;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepoInterface
{
    public function create(array $req): ModelsTodo;
    public function findAll(TodoPaginationRequest $req, int $offset): array;
    public function findById(int $id): ?array;
    public function getCount(?string $keyword): int;
    public function update(array $req, int $id): int;
    public function delete(int $id): bool;
}
