<?php

namespace App\ViewModels\Request;

class TodoPaginationRequest
{
    public ?string $keyword;
    public string $orderBy = 'id';
    public string $sort;
    public int $page = 1;
    public int $limit = 10;
}
