<?php

namespace MightyWeb\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Walkthrough extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mightyweb_walkthroughs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'image',
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
     * Scope a query to only include active walkthroughs.
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
     * Get the full URL for the walkthrough image.
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

        return Storage::disk($disk)->url($path . '/walkthrough/' . $this->image);
    }

    /**
     * Delete the walkthrough image from storage.
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
        $fullPath = $path . '/walkthrough/' . $this->image;

        return Storage::disk($disk)->exists($fullPath) 
            ? Storage::disk($disk)->delete($fullPath)
            : false;
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (Walkthrough $walkthrough) {
            $walkthrough->deleteImage();
        });
    }
}
