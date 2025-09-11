<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
     protected $fillable = [
        'title',
        'description',
        'max_participants',
        'event_start',
        'event_end',

    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserEvent::class, 'event_id','user_id',)->withTimestamps();
    }
}
