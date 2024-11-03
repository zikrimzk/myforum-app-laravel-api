<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable=[
        'content',
        'user_id'
    ];
    protected $appends= ['liked'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comment():HasMany
    {
        return $this->hasMany(Comment::class);
    }


    public function getLikedAttribute(): bool
    {
        return (bool) $this->likes()->where('post_id',$this->id)->where('user_id',auth()->user()->id)->exists();
    }
}
