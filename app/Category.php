<?php

namespace App;

use App\Traits\Slug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Category extends Model
{
    //use HasSlug;
    use Slug;
    protected $fillable = ['name', 'description', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    /*
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    */

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
