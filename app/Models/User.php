<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;
    use TwoFactorAuthenticatable;


    protected $dates = ['created_at'];
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "mobile_number",
        "country_id",
        "zip_code",
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'roles',
        'media'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url', 'profile_photo_srcs', 'role_name', 'role'
    ];

    public function getRoleNameAttribute()
    {
        return $this->getRoleNames()->implode(', ');;
    }

    public function getRoleAttribute()
    {
        return $this->getRoleNames()->implode(', ');;
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function babies()
    {
        return $this->hasMany(Babies::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        $media = $this->getFirstMedia('profile_photo');
        if ($media) {
            return $media->getUrl();
        }
        return null;
    }

    public function getProfilePhotoSrcsAttribute()
    {
        $media = $this->getFirstMedia('profile_photo');
        if ($media) {
            return [
                'default' => $media->getUrl('default'),
                'preview_thumbnail' => $media->getUrl('preview_thumbnail'),
                'thumbnail' => $media->getUrl('thumbnail'),
            ];
        }
        return null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $thumbnailWidth  = 50;
        $thumbnailHeight = 50;

        $thumbnailPreviewWidth  = 120;
        $thumbnailPreviewHeight = 120;

        $this->addMediaConversion('thumbnail')
            ->width($thumbnailWidth)
            ->height($thumbnailHeight)
            ->fit('crop', $thumbnailWidth, $thumbnailHeight);

        $this->addMediaConversion('preview_thumbnail')
            ->width($thumbnailPreviewWidth)
            ->height($thumbnailPreviewHeight)
            ->fit('crop', $thumbnailPreviewWidth, $thumbnailPreviewHeight);

        $this->addMediaConversion('default')
            ->width(600)
            ->height(600)
            ->fit(Manipulations::FIT_CONTAIN, 600, 600);
    }
}
