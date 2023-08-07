<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Label;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFiltered(Builder $query, string $sort) {
        if ($sort == 'statusAsc'){
            $query->orderBy('is_open', 'asc');
        } else if ($sort == 'statusDsc'){
            $query->orderBy('is_open', 'desc');
        } else if ($sort == 'priorityAsc'){
            $query->orderBy('priority', 'asc');
        } else if ($sort == 'priorityDsc'){
            $query->orderBy('priority', 'desc');
        }
    }

    public function getImportanceAttribute() {
        if ($this->priority == 0) {
            return 'Low';
        } else if ($this->priority == 1) {
            return 'Medium';
        } else {
            return 'High';
        }
    }

    public function getStatusAttribute() {
        if ($this->is_open) {
            return 'Open';
        }
        return 'Closed';
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent() {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function labels() {
        return $this->belongsToMany(Label::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
