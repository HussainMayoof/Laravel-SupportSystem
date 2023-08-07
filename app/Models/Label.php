<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tickets() {
        return $this->belongsToMany(Ticket::class);
    }
}
