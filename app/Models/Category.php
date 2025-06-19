<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, HasUuids, HasSlug;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'slug', 'description', 'status',  'parent_id'];

    protected $casts = [
        'status' => 'boolean',
    ];


    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }


    public function categoryParent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, CategoryProduct::class)
            ->withTimestamps();
    }
}
