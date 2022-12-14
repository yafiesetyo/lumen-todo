<?php

namespace App\ViewModels\Response;

class TodoResponse
{
    public int $statusCode;
    public string $message;
    public ?array $data;
    public ?TodoPaginationResponse $pagination;

    public function __construct(int $statusCode, string $message, ?array $data, ?TodoPaginationResponse $pagination)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
        $this->pagination = $pagination;
    }

    public function get(): TodoResponse
    {
        return $this;
    }
}
