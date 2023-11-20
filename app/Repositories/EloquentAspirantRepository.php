<?php

namespace App\Repositories;

use App\Models\Aspirant;

class EloquentAspirantRepository implements AspirantRepositoryInterface
{
    public function getAll()
    {
        return Aspirant::all();
    }

    public function getById($id)
    {
        return Aspirant::find($id);
    }

    public function create(array $data)
    {
        return Aspirant::create($data);
    }
    public function getByOwner($ownerId)
    {
        return Aspirant::where('owner', $ownerId)->get();
    }
}