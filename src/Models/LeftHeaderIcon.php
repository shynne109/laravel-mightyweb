<?php

namespace MightyWeb\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LeftHeaderIcon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mightyweb_left_header_icons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'value',
        'image',
        'type',
        'url',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the database connection for the model.
     *
     * @return string|null
     */
    public function getConnectionName(): ?string
    {
        return config('mightyweb.database.connection') ?? $this->connection;
    }

    /**
     * Scope a query to only include active icons.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the full URL for the icon image.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $path = config('mightyweb.storage.path', 'mightyweb');

        return Storage::disk($disk)->url($path . '/lefticon/' . $this->image);
    }

    /**
     * Delete the icon image from storage.
     *
     * @return bool
     */
    public function deleteImage(): bool
    {
        if (!$this->image) {
            return false;
        }

        $disk = config('mightyweb.storage.disk', 'public');
        $path = config('mightyweb.storage.path', 'mightyweb');
        $fullPath = $path . '/lefticon/' . $this->image;

        return Storage::disk($disk)->exists($fullPath) 
            ? Storage::disk($disk)->delete($fullPath)
            : false;
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (LeftHeaderIcon $icon) {
            $icon->deleteImage();
        });
    }
}
