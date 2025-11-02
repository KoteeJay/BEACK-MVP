<?php

namespace App\Models;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        
        'body',
        'image',
        'user_id',
        'slug',
        'published_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'posts';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if ($post->slug) {
                $post->slug = Str::limit($post->slug, 70, '-'); 
            }
        });
        static::saving(function ($post) {
            if ($post->body) {
                $post->body = Str::limit($post->body, 2000, '');
            }
        });
    }
    public function likes()
    {
        // return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
        return $this->hasMany(Like::class);
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
    }
 
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
