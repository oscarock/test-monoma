<?php

namespace App\Repositories;

use App\Models\Aspirant;

interface AspirantRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function getByOwner($ownerId);
}