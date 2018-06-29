<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 14:07.
 */

namespace App\Model;

use Carbon\Carbon;
use App\Model\Concerns\ActivityFeed;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Roles\Interfaces\RoleInterface;
use App\Classes\Roles\Exceptions\InvalidRoleType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Accounts.
 *
 * @property Role role
 *
 * @property HasMany $pages
 * @property HasMany $articles
 * @property HasMany $menus
 * @property HasMany $redirects
 *
 * @property Carbon $deleted_at
 * @property Carbon $last_login
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int $id
 * @property string $avatar
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $forename
 * @property string $surname
 * @property string $address
 * @property int $role_id
 * @property string $number
 * @property int $status
 * @property int $verified
 * @property int $login_count
 * @property string $ip_address
 */
class Account extends Authenticatable
{
    /*
     * Laravel Deleting.
     *
     * @ https://laravel.com/docs/5.5/eloquent#soft-deleting
     */
    use SoftDeletes;
    /*
     * Log users activity on this model.
     *
     * @ https://docs.spatie.be/laravel-activitylog/v2/advanced-usage/logging-model-events
     */
    use ActivityFeed;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * Default attributes for the model.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login', 'created_at'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['remember_token', 'password'];

    /**
     * If your model contains attributes whose change don't need to trigger an activity being logged
     * you can use $ignoreChangedAttributes.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = ['remember_token', 'last_login', 'updated_at'];

    /**
     * The activity logging strings to be used.
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} the account belonging to {$this->fullName()}";
    }

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Get the role attached to the account.
     *
     * @return Role $model
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Return the full name of the account.
     *
     * @return string
     */
    public function fullName()
    {
        return $this->forename.' '.$this->surname;
    }

    /**
     * Set the password attribute field on the model.
     *
     * @param string $password
     * @return bool
     */
    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Return the url to link the users email to a profile picture.
     *
     * @return string The generated url fromt he user email.
     */
    private function getGravatar()
    {
        return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->getAttribute('email'))));
    }

    /**
     * Generate an avatar Image for the user.
     *
     * @return void
     */
    public function getAvatarAttribute()
    {
        return url('images/avatar-default.png');
    }

    /**
     * @return HasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class, 'creator_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'creator_id', 'id');
    }

    /**
     * Return the generated redirects by the user.
     *
     * @param array $attributes
     * @return Redirect|HasMany
     */
    public function redirects($attributes = [])
    {
        if (isset($attributes['modifier'])) {
            return $this->hasMany(Redirect::class, 'modifier_id', 'id');
        }

        return $this->hasMany(Redirect::class, 'creator_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Plugins\Articles\Model\Article', 'creator_id')->latest('created_at');
    }

    /**
     * Get the access logs from belonging to the model.
     *
     * @return AccessLog
     */
    public function access()
    {
        return $this->hasMany(AccessLog::class, 'email', 'email');
    }

    /**
     * Resolve the ID of the logged User.
     *
     * @return mixed|null
     */
    public static function resolveId()
    {
        return auth()->check() ? auth()->user()->getAuthIdentifier() : null;
    }

    /**
     * Check if the account has a role.
     *
     * @param string $name
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            $class = sprintf('App\Classes\Roles\%s', $role);

            return $this->hasRole(app()->make($class));
        }

        if ($role instanceof RoleInterface) {
            return $role->validate($this);
        }

        throw new InvalidRoleType('The role is not a correct format or does not exist.');
    }

    /**
     * Apply a role to the account.
     *
     * @param RoleInterface $role
     * @return void
     * @throws InvalidRoleType
     */
    public function setRole($role)
    {
        if (is_string($role)) {
            $class = sprintf('App\Classes\Roles\%s', $role);

            return $this->setRole(app()->make($class));
        }

        if ($role instanceof RoleInterface) {
            return $role->apply($this);
        }

        throw new InvalidRoleType('The role is not a correct format or does not exist.');
    }
}
