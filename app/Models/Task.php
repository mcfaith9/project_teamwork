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
    
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')->withPivot('user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
                    ->withPivot('user_id')
                    ->select('users.name');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function timeLogs()
    {
        return $this->belongsToMany(User::class, 'task_time_log')
                    ->withPivot(['user_id','prev_time_today', 'time_log'])
                    ->withTimestamps();
    }
}
