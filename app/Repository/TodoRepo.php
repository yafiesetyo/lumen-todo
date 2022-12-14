<?php

namespace App\Repository;

use App\Models\Todo as ModelsTodo;
use App\Repository\Contracts\TodoRepoInterface;
use App\ViewModels\Request\TodoPaginationRequest;

class TodoRepo implements TodoRepoInterface
{
    public function create(array $req): ModelsTodo
    {
        return ModelsTodo::create($req);
    }

    public function update(array $req, int $id): int
    {
        return ModelsTodo::where('id', $id)
            ->update($req);
    }

    public function delete(int $id): bool
    {
        $todo = ModelsTodo::where('id', $id);

        return $todo->delete();
    }

    public function findAll(TodoPaginationRequest $req, int $offset): array
    {
        $todo = new ModelsTodo();

        if (!is_null($req->keyword) || $req->keyword != "") {
            $todo = $todo->where('title', 'like', '%' . $req->keyword . '%');
        }
        $todo = $todo->orderBy($req->orderBy, $req->sort);
        $todo = $todo->limit($req->limit)->offset($offset);

        return $todo->get()->toArray();
    }

    public function getCount(?string $keyword): int
    {
        if ($keyword != "" || !is_null($keyword)) {
            return ModelsTodo::where('title', 'like', '%' . $keyword . '%')->count();
        }
        return ModelsTodo::count();
    }

    public function findById(int $id): ?array
    {
        $todo = ModelsTodo::where('id', $id)
            ->first();
        if ($todo == null) {
            return null;
        }

        return $todo->toArray();
    }
}
