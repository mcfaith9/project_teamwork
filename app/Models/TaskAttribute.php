<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskAttribute extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'task_id',
        'progress',
        'tag',
        'flag',
        'reminder',
        'start_date',
        'due_data',
        'estimate',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
