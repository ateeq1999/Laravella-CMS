<?php

namespace App\Http\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Page extends Model implements TranslatableContract
{
    use Cachable;

    use Translatable;

    public $timestamps = false;

    public $translatedAttributes = ['title', 'template', 'page_id', 'created_at', 'updated_at', 'slug', 'author_id', 'status', 'custom_fields', 'content', 'meta_keywords', 'meta_description'];

    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'page_id',
        'status',
        'template',
        'content',
        'custom_fields',
        'meta_keywords',
        'meta_description',
        'updated_at',
        'created_at'
    ];

    public function author()
    {
        return $this->hasOne('App\Http\Models\User','id', 'author_id');
    }


}
