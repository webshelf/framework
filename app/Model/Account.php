<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 14:07.
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $forename
 * @property string $surname
 * @property string $address
 * @property string $number
 * @property int $role_id
 * @property int $status
 * @property int $verified
 * @property int $login_count
 * @property string $ip_address
 */
class Account extends Authenticatable
{
    /*
     * Soft Delete trait
     */
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login', 'created_at'];

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
     * Check if the user has the role.
     * @info Role::groups.
     *
     * @param int $role_id
     * @param bool $rule
     * @return bool
     */
    public function hasRole(int $role_id, bool $rule = true)
    {
        return ($this->role->id() <= $role_id) == $rule;
    }

    /**
     * @return string
     */
    public function makeGravatarImage()
    {
        return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
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
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'creator_id', 'id');
    }

    /**
     * @return Role|BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
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
     * Generate a bCrpyt string for new password enties.
     *
     * @param string $string
     * @return $this
     */
    public function setPassword(string $string)
    {
        return $this->setAttribute('password', bcrypt($string));
    }
}
