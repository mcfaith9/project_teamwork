<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'task_id', 'body'];
    protected $appends = ['image_url'];
    protected $casts = ['attachments' => 'array'];

    public function getImageUrlAttribute()
    {
        if (!empty($this->attachments)) {
            $attachmentPaths = json_decode($this->attachments);
            $urls = [];
            foreach ($attachmentPaths as $attachment) {
                $urls[] = asset('storage/' . $attachment);
            }
            return $urls;
        }

        return null;
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
