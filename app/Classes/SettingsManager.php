<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 19/09/2016
 * Time: 21:34.
 */

namespace App\Classes;

use App\Model\Setting;
use Illuminate\Support\Collection;

/**
 * Class Settings.
 */
class SettingsManager
{
    /**
     * A storage of all the settings being held for usage.
     *
     * @var Collection
     */
    private $settings;

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->settings = new Collection;
    }

    /**
     * Add a new setting to the container.
     *
     * @param $key
     * @param $value
     * @param null $shadow
     * @internal param array $array
     * @return Collection
     */
    public function add($key, $value, $shadow = null)
    {
        return $this->settings->put($key, ['key' => $key, 'value' => $value, 'shadow' => $shadow]);
    }

    /**
     * Remove a setting from the container.
     *
     * @param $key
     * @return Collection
     */
    public function remove($key)
    {
        return $this->settings->forget($key);
    }

    /**
     * Edit a setting from the container.
     *
     * @param $key
     * @param $value
     * @return Collection
     */
    public function set($key, $value)
    {
        return $this->add($key, $value);
    }

    /**
     * Check if settings exists.
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return $this->settings->has($key);
    }

    /**
     * Get a value from the container.
     * This represents the default value of the key.
     *
     * @param $key
     */
    public function getValue($key)
    {
        return $this->settings->get($key)['value'];
    }

    /**
     * Get the shadow value from the container.
     * This represents the original default of the key.
     *
     * @param $key
     */
    public function getShadow($key)
    {
        return $this->settings->get($key)['shadow'];
    }

    /**
     * Get the settings default key.
     *
     * If the user did not enter a value, we can use the shadow value.
     *
     * @param $key
     * @return mixed
     */
    public function getDefault($key)
    {
        $key = $this->settings->get($key);

        return $key['value'] ?: $key['shadow'];
    }

    /**
     * Count the available settings.
     *
     * @return int
     */
    public function count()
    {
        return $this->settings->count();
    }

    /**
     * For tenant usage, we must add a collection of settings models from the database.
     *
     * Can be used for anything else though.
     *
     * @param Collection $collection
     * @return $this
     */
    public function collect(Collection $collection)
    {
        /** @var Setting $model */
        foreach ($collection as $model) {
            $this->add($model->key(), $model->value(), $model->shadow());
        }

        return $this;
    }
}
