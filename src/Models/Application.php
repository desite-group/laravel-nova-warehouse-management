<?php

namespace DesiteGroup\LaravelNovaWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Application extends Model implements Sortable, HasMedia
{
    use HasFactory, InteractsWithMedia, SortableTrait;

    protected $fillable = [
        'document_number', 'organization',
        'organization_address', 'organization_chief_name', 'organization_chief_surname', 'organization_chief_patronymic',
        'additional_text', 'internal_comment', 'type', 'needs'
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main')
            ->format(Manipulations::FORMAT_JPG)
            ->fit(Manipulations::FIT_MAX, 800, 800)
            ->performOnCollections('photo');

        $this->addMediaConversion('thumb_main')
            ->format(Manipulations::FORMAT_JPG)
            ->fit(Manipulations::FIT_MAX, 20, 20)
            ->performOnCollections('photo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
