<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
