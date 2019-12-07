<?php

namespace App\Http\Models;

use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Post extends Model implements TranslatableContract
{
    use Cachable;

    use SoftDeletes;

    use Translatable;

    public $timestamps = false;

    public $translatedAttributes = ['title', 'post_id', 'created_at', 'updated_at', 'author_id', 'slug', 'thumbnail', 'preview', 'status', 'content', 'meta_keywords', 'meta_description'];

    protected $fillable = [
        'created_at',
        'updated_at',
        'likes'
    ];

    public function author()
    {
        return $this->hasOne('App\Http\Models\User','id', 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_post');
    }


    public function likes()
    {
        return $this->belongsTo(Likes::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class)->whereNull('parent_id')->where('status', 1)->with('user')->with('replies');
    }

    public function allCommentsCount()
    {
        return $this->hasMany(Comments::class)->where('status', 1);
    }


}
