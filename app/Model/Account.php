<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 14:07.
 */

namespace App\Model;

use Carbon\Carbon;
use App\Model\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

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

    /**
     * Spatie Roles and Permissions.
     * 
     * @ https://github.com/spatie/laravel-permission
     */
    use HasRoles;

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
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['remember_token', 'password'];

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
     * @deprecated 5.7
     * @return string
     */
    public function makeGravatarImage()
    {
        return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
    }

    /**
     * Return the url to link the users email to a profile picture.
     *
     * @return string
     */
    public function gravatarUrl()
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
        return $this->hasMany(Article::class, 'creator_id', 'id');
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

    /**
     * Resolve the ID of the logged User.
     *
     * @return mixed|null
     */
    public static function resolveId()
    {
        return auth()->check() ? auth()->user()->getAuthIdentifier() : null;
    }
}
