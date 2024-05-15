<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class DocumentMenu extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'json',
        'html',
        'document_id',
        'parent_id',
        'position',
    ];

    public function document()
    {
        return DocumentMenu::where('id',$this->id)->get();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
