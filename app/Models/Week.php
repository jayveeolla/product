<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Week extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $hidden = ['media'];
    protected $table = "products";
    protected $appends = [
        'photo', 'photo_media'
    ];

    protected $fillable = [
        'product_title',
        'price',
        'quanity',
        'sku',
        'colour',
        'image',
        'product_ingredients',
    ];


    public function getPhotoMediaAttribute()
    {
        $media = $this->getFirstMedia('photo');
        if ($media) {
            return $media;
        }
        return null;
    }
    public function getPhotoAttribute()
    {
        $media = $this->getFirstMedia('photo');
        if ($media) {
            return $media->getUrl();
        }
        return null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(1000)
            ->height(250);
    }
}
