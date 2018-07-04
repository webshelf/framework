<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Undocumented class
 *
 * @property string $key
 * @property string $value
 * @property string $description
 *
 * @property Carbon $updated_at
 *
 */
class Configuration extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_config';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['updated_at'];

    /**
     * Get the description of a configuration by its keyname.
     *
     * @param string $configName
     * @return mixed
     */
    public static function getDescription(string $configName)
    {
        return Configuration::where('key', $configName)->first()->description;
    }

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public static function set(string $key, string $value)
    {
        return Configuration::where('key', $key)->first()->update(['value', $value]);
    }
}
