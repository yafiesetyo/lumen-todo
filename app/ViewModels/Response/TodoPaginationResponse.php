<?php

namespace App\ViewModels\Response;

class TodoPaginationResponse
{
    public int $page;
    public int $totalData;
    public int $limit;
    protected int $totalPage;

    public function __construct(int $page, int $totalData, int $limit)
    {
        $this->page = $page;
        $this->totalData = $totalData;
        $this->limit = $limit;
    }

    public function getMetadata(): TodoPaginationResponse
    {
        $perPage = $this->totalData / $this->limit;
        $this->totalPage = ceil($perPage);
        if ($this->totalPage == 0) {
            $this->totalPage = 1;
        }

        return $this;
    }
}
