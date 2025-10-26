<?php

namespace MightyWeb\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mightyweb_menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'type',
        'image',
        'url',
        'status',
        'parent_id',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'parent_id' => 'integer',
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
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->ordered();
    }

    /**
     * Scope a query to only include active menus.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include parent menus.
     */
    public function scopeParents($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * Scope a query to order by the order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the full URL for the menu image.
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

        return Storage::disk($disk)->url($path . '/menu/' . $this->image);
    }

    /**
     * Check if the menu has children.
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Delete the menu image from storage.
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
        $fullPath = $path . '/menu/' . $this->image;

        return Storage::disk($disk)->exists($fullPath) 
            ? Storage::disk($disk)->delete($fullPath)
            : false;
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (Menu $menu) {
            // Delete children
            $menu->children()->each(fn($child) => $child->delete());
            
            // Delete image
            $menu->deleteImage();
        });
    }
}
