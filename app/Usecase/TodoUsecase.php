<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Repository\Contracts\TodoRepoInterface;
use App\Usecase\Contracts\TodoUsecaseInterface;
use App\ViewModels\Response\TodoPaginationResponse;
use App\ViewModels\Response\TodoResponse;
use App\ViewModels\TodoVM;
use App\ViewModels\Request\TodoPaginationRequest;
use Illuminate\Support\Facades\Log;

class TodoUsecase implements TodoUsecaseInterface
{
    protected $repo;
    public function __construct(TodoRepoInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create(TodoVM $req): TodoResponse
    {
        Log::info('performing create todo data', ['todoUsecase.Create']);
        try {
            $this->repo->create((array) $req);
        } catch (\Throwable $th) {
            Log::error('getting error when create new todo, error: ' . $th->getMessage(), ['todoUsecase.create']);
            $newResp = new TodoResponse(500, $th->getMessage(), null, null);
            $resp = $newResp->get();
            return $resp;
        }
        $resp = new TodoResponse(201, 'created', null, null);
        return $resp->get();
    }

    public function findAll(TodoPaginationRequest $req): TodoResponse
    {
        $data = null;
        $count = 0;
        $offset = ($req->page - 1) * $req->limit;

        try {
            $data = $this->repo->findAll($req, $offset);
        } catch (\Throwable $th) {
            Log::error('getting error when get all todo data, error: ' . $th->getMessage(), ['todoUsecase.findAll']);
            $newResp = new TodoResponse(500, $th->getMessage(), null, null);
            $resp = $newResp->get();
            return $resp;
        }

        try {
            $count = $this->repo->getCount($req->keyword);
        } catch (\Throwable $th) {
            Log::error('getting error when get all todo count, error: ' . $th->getMessage(), ['todoUsecase.findAll']);
            $newResp = new TodoResponse(500, $th->getMessage(), null, null);
            $resp = $newResp->get();
            return $resp;
        }

        $paginationResp = new TodoPaginationResponse($req->page, $count, $req->limit);
        $resp = new TodoResponse(200, 'ok', array_values($data), $paginationResp->getMetadata());
        return $resp->get();
    }

    public function update(int $id, TodoVM $req): TodoResponse
    {
        try {
            $this->repo->update((array)$req, $id);
        } catch (\Throwable $th) {
            Log::error('getting error when update, error: ' . $th->getMessage(), ['todoUsecase.update']);
            $resp = new TodoResponse(500, $th->getMessage(), array_values((array)$req), null);
            return $resp->get();
        }

        $resp = new TodoResponse(200, 'ok', array_values((array)$req), null);
        return $resp->get();
    }

    public function delete(int $id): TodoResponse
    {
        try {
            $this->repo->delete($id);
        } catch (\Throwable $th) {
            Log::error('getting error when delete, error: ' . $th->getMessage(), ['todoUsecase.delete']);
            $resp = new TodoResponse(500, $th->getMessage(), null, null);
            return $resp->get();
        }

        $resp = new TodoResponse(200, 'ok', null, null);
        return $resp->get();
    }

    public function findById(int $id): TodoResponse
    {
        $todo = [];
        try {
            $todo = $this->repo->findById($id);
        } catch (\Throwable $th) {
            Log::error('getting error when get by id, error: ' . $th->getMessage(), ['todoUsecase.findById']);
            $resp = new TodoResponse(500, $th->getMessage(), null, null);
            return $resp->get();
        }
        $resp = new TodoResponse(200, 'ok', $todo, null);
        return $resp->get();
    }
}
