<?php

namespace MightyWeb\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tab extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mightyweb_tabs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'image',
        'url',
        'status',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
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
     * Scope a query to only include active tabs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to order by the order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the full URL for the tab image.
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

        return Storage::disk($disk)->url($path . '/tabs/' . $this->image);
    }

    /**
     * Delete the tab image from storage.
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
        $fullPath = $path . '/tabs/' . $this->image;

        return Storage::disk($disk)->exists($fullPath) 
            ? Storage::disk($disk)->delete($fullPath)
            : false;
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (Tab $tab) {
            $tab->deleteImage();
        });
    }
}
