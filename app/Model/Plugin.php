<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 14:42.
 */

namespace App\Model;

use App\Plugins\PluginHandler;
use App\Model\Model;

/**
 * Class Plugins.
 *
 * @property string $name
 *
 * @property bool $required
 * @property bool $enabled
 *
 * @property PluginHandler $handler
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

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
     * Return the plugins namespace.
     *
     * @return string
     */
    protected function dirNamespace()
    {
        return sprintf("App\Plugins\%s", ucfirst($this->name));
    }

    /**
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
        return $this->handler->icon();
    }

    public function name()
    {
        return $this->name;
    }

    public function version()
    {
        return $this->handler->version();
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

    public function install()
    {
        $controller = app(printf("App\Plugins\%s", $this->name));

        $controller->install();
    }
}
