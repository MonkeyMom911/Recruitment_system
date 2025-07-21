<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('settings');
        });

        static::deleted(function () {
            Cache::forget('settings');
        });
    }

    /**
     * Get all settings as key-value pairs.
     *
     * @return array
     */
    public function getAll()
    {
        return Cache::rememberForever('settings', function () {
            return static::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get a setting by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $settings = $this->getAll();

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value.
     *
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value = null)
    {
        $data = is_array($key) ? $key : [$key => $value];

        foreach ($data as $k => $v) {
            static::updateOrCreate(['key' => $k], ['value' => $v]);
        }

        Cache::forget('settings');
    }

    /**
     * Save settings and persist to database.
     *
     * @return void
     */
    public function save($options = [])
    {
        Cache::forget('settings');
        return parent::save($options);
    }
}
