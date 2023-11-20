<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "name",
        "source",
        "owner",
        "created_at",
        "created_by"
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
