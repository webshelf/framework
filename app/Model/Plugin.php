<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 14:42.
 */

namespace App\Model;

use App\Plugins\PluginHandler;
use Illuminate\Support\Facades\App;

/**
 * Class Plugins.
 *
 * @property string $name
 *
 * @property bool $required
 * @property string $controller
 *
 * @property Plugin $options
 */
class Plugin extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plugins';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['enabled' => 'boolean', 'required' => 'boolean'];

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Toggle the enabled status of the plugin.
     *
     * @return bool
     */
    public function toggle()
    {
        return $this->update(['enabled' => ! $this->enabled]);
    }

    /**
     * Return the namespace path to the controller of the plugin.
     *
     * @return string
     */
    public function getControllerAttribute()
    {
        return app()->make(sprintf("App\Plugins\%s\%sController", $this->name, $this->name));
    }

    /**
     * Call the install method on the plugins controller.
     *
     * @param string $plugin_name The plugin name to install
     * @return Plugin The model instance of the installed plugin
     */
    public static function install(string $plugin_name)
    {
        $plugin = self::whereName($plugin_name)->first();

        $plugin->update(['enabled' => true]);

        $plugin->controller->install();

        return $plugin;
    }

    /**
     * @deprecated
     * @return PluginHandler
     */
    protected function getHandlerAttribute()
    {
        return app(sprintf("%s\%sController", $this->dirNamespace(), ucfirst($this->name)));
    }

    /**
     * ==========================================================.
     *
     *   GET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function icon()
    {
        return $this->controller->icon();
    }

    public function name()
    {
        return $this->name;
    }

    public function version()
    {
        return $this->controller->version();
    }

    public function isEnabled()
    {
        return $this->getAttribute('enabled') == true;
    }

    public function isDisabled()
    {
        return $this->getAttribute('enabled') == false;
    }

    public function isFrontEnd()
    {
        return $this->getAttribute('is_frontend');
    }

    public function isBackEnd()
    {
        return $this->getAttribute('is_backend');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    public function getUpdatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    public function setEnabled($boolean)
    {
        if ($boolean == true) {
            return $this->enable();
        }

        return $this->disable();
    }

    /**
     * Enable the product.
     *
     * @return $this
     */
    public function enable()
    {
        $this->setAttribute('enabled', true);

        return $this;
    }

    /**
     * Disable the product.
     *
     * @return $this
     */
    public function disable()
    {
        $this->setAttribute('enabled', false);

        return $this;
    }

    public function setInstalled(bool $boolean)
    {
        $this->setAttribute('installed', $boolean ? 1 : 0);

        return $this;
    }

    /**
     * @return mixed
     */
    public function isInstalled()
    {
        return $this->getAttribute('installed') ? true : false;
    }

    public function setName($string)
    {
        $this->setAttribute('name', $string);

        return $this;
    }

    public function setVersion($integer)
    {
        $this->setAttribute('version', $integer);

        return $this;
    }

    public function setIcon($string)
    {
        $this->setAttribute('icon', $string);

        return $this;
    }

    public function adminUrl()
    {
        if ($this->isBackEnd()) {
            return route("admin.{$this->name}.index");
        }

        throw new \Exception('This is not a backend enabled plugin and should not be used here.');
    }

    public function userUrl()
    {
        if ($this->isFrontEnd()) {
            return url($this->name());
        }

        throw new \Exception('This is not a frontend enabled plugin and should not be used here.');
    }

    public function isHidden()
    {
        return $this->getAttribute('hidden') ? true : false;
    }

    public function setHide(bool $boolean)
    {
        $this->setAttribute('hidden', $boolean ? 1 : 0);

        return $this;
    }

    public function setRequired($boolean)
    {
        $this->setAttribute('required', $boolean);

        return $this;
    }

    public function setFrontEnd($boolean)
    {
        $this->setAttribute('is_frontend', $boolean);

        return $this;
    }

    public function setBackEnd($boolean)
    {
        $this->setAttribute('is_backend', $boolean);

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(PluginOption::class, 'plugin_id', 'id');
    }

    public function option($key)
    {
        return $this->options->where('key', $key)->first()->value();
    }

    public function feeds()
    {
        return $this->hasMany(PluginFeed::class, 'plugin_id', 'id');
    }
}
