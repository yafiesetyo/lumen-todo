<?php

declare(strict_types=1);

namespace App\Usecase\Contracts;

use App\ViewModels\Request\TodoPaginationRequest;
use App\ViewModels\Response\TodoPaginationResponse;
use App\ViewModels\TodoVM;
use App\ViewModels\Response\TodoResponse;

interface TodoUsecaseInterface
{
    /**
     * Create new to-do data
     */
    public function create(TodoVM $req): TodoResponse;
    /**
     * Find all data using pagination
     */
    public function findAll(TodoPaginationRequest $req): TodoResponse;
    /**
     * Find data by id
     */
    public function findById(int $id): TodoResponse;
    /**
     * Update existing to-do data by id
     */
    public function update(int $id, TodoVM $req): TodoResponse;
    /**
     * delete existing to-do data by id
     */
    public function delete(int $id): TodoResponse;
}
