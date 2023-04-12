<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'creator_id',
        'assignee_id'
    ];

    protected $casts = [
        'assignee_id' => 'array',
        'assignees' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
    
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }


    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id')->select('name');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
