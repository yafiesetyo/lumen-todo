<?php

namespace App\Http\Controllers;

use App\Constants\OrderBy;
use App\Usecase\Contracts\TodoUsecaseInterface;
use App\ViewModels\Request\TodoPaginationRequest;
use App\ViewModels\TodoVM;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $usecase;
    public function __construct(TodoUsecaseInterface $uc)
    {
        $this->usecase = $uc;
    }

    public function create(Request $req)
    {
        try {
            $this->validate($req, [
                'name' => 'required',
                'description' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }

        $payload = new TodoVM();
        $payload->title = $req['name'];
        $payload->description = $req['description'];
        $payload->isDone = false;

        $resp = $this->usecase->create($payload);
        return response()->json($resp, $resp->statusCode);
    }

    public function findAll(Request $req)
    {
        $query = $req->query();

        $payload = new TodoPaginationRequest();
        $payload->page = $query['page'];
        $payload->keyword = $query['keyword'];
        $payload->orderBy = $query['orderBy'];
        $payload->limit = $query['limit'];
        $payload->sort = OrderBy::defaultSort($query['sort']);

        $resp = $this->usecase->findAll($payload);

        return response()->json($resp, $resp->statusCode);
    }

    public function findById($id)
    {
        $resp = $this->usecase->findById($id);
        return response()->json($resp, $resp->statusCode);
    }

    public function update(Request $req, $id)
    {
        try {
            $this->validate($req, [
                'name' => 'required',
                'description' => 'required',
                'isDone' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }

        $payload = new TodoVM();
        $payload->title = $req['name'];
        $payload->description = $req['description'];
        $payload->isDone = $req['isDone'];

        $resp = $this->usecase->update($id, $payload);
        return response()->json($resp, $resp->statusCode);
    }

    public function delete($id)
    {
        $resp = $this->usecase->delete($id);
        return response()->json($resp, $resp->statusCode);
    }
}
