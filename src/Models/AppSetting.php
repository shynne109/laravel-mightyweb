<?php

namespace MightyWeb\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class AppSetting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mightyweb_app_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'array',
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
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set(string $key, $value): bool
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        ) ? true : false;
    }

    /**
     * Get all settings as key-value pairs.
     *
     * @return array
     */
    public static function getAllSettings(): array
    {
        return static::query()
            ->pluck('value', 'key')
            ->toArray();
    }
}
