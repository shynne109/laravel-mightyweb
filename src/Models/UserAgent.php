<?php

namespace MightyWeb\Models;

use Illuminate\Database\Eloquent\Model;

class UserAgent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mightyweb_user_agents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'android',
        'ios',
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
     * Scope a query to only include active user agents.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the active user agent configuration.
     *
     * @return UserAgent|null
     */
    public static function getActive(): ?UserAgent
    {
        return static::active()->first();
    }
}
