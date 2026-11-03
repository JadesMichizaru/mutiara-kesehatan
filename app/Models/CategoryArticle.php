<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryArticle extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories_article';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'slug'];

    public function posts(): HasMany {
        return $this->hasMany(PostArticle::class, 'category_id');
    }
}
