<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostArticle extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'posts_article';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(CategoryArticle::class, 'category_id');
    }
}
