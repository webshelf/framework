<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 14:07.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Accounts.
 *
 * @property Role $role
 * @property Menu $menus
 */
class Account extends Authenticatable
{
    protected $attributes = [
        'forename' => '', // these require defaults due to registrations.
        'surname'  => '', // these require defaults due to registrations.
        'password' => '', // these require defaults due to registrations.
    ];

    protected $table = 'accounts';

    protected $dates = ['last_login', 'created_at'];

    use SoftDeletes;

    protected $softDelete = true;

    /**
     * ==========================================================.
     *
     *   GET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function id()
    {
        return $this->getAttribute('id');
    }

    public function setID($integer)
    {
        $this->setAttribute('id', $integer);

        return $this;
    }

    public function email()
    {
        return $this->getAttribute('email');
    }

    public function surname()
    {
        return $this->getAttribute('surname');
    }

    public function address()
    {
        return $this->getAttribute('address');
    }

    public function forename()
    {
        return $this->getAttribute('forename');
    }

    public function password()
    {
        return $this->getAttribute('password');
    }

    public function number()
    {
        return $this->getAttribute('number');
    }

    public function ipAddress()
    {
        return $this->getAttribute('ip_address');
    }

    public function loginCount()
    {
        return $this->getAttribute('login_count') ?: 0;
    }

    public function lastLogin()
    {
        return $this->getAttribute('last_login');
    }

    public function createdAt()
    {
        return $this->getAttribute('created_at');
    }

    /**
     * ==========================================================.
     *
     *   GET THE ATTRIBUTES OF THE MODEL
     *
     * ==========================================================
     */
    public function setEmail($string)
    {
        $this->setAttribute('email', $string);

        return $this;
    }

    public function setPassword($string)
    {
        $this->setAttribute('password', $string);

        return $this;
    }

    public function setForename($string)
    {
        $this->setAttribute('forename', $string);

        return $this;
    }

    public function setSurname($string)
    {
        $this->setAttribute('surname', $string);

        return $this;
    }

    public function setAddress($text)
    {
        $this->setAttribute('address', $text);

        return $this;
    }

    public function setNumber($integer)
    {
        $this->setAttribute('number', $integer);

        return $this;
    }

    public function setLoginCount($integer)
    {
        $this->setAttribute('login_count', $integer);

        return $this;
    }

    public function setIpAddress($string)
    {
        $this->setAttribute('ip_address', $string);

        return $this;
    }

    public function setLastLogin($timestamp)
    {
        $this->setAttribute('last_login', $timestamp);

        return $this;
    }

    /**
     * Relationship data with the pages.
     * @return mixed
     */
    public function pages()
    {
        return $this->hasMany(Page::class, 'creator_id', 'id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'creator_id', 'id');
    }

    public function fullName()
    {
        return $this->forename().' '.$this->surname();
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'creator_id', 'id');
    }

    public function setName($forename, $surname)
    {
        $this->setForename($forename);

        $this->setSurname($surname);

        return $this;
    }

    /**
     * Since we store the original creator and modifier.
     * we can accept a second parameter to state its a modifier.
     *
     * @param array $attributes - Modifier = Return as a redirect modifier not creator.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @internal param bool $modifier
     */
    public function redirects($attributes = [])
    {
        if (isset($attributes['modifier'])) {
            return $this->hasMany(Redirect::class, 'modifier_id', 'id');
        }

        return $this->hasMany(Redirect::class, 'creator_id', 'id');
    }

    /**
     * Check if the current user is administrator at coffeebreak cms.
     *
     * @param bool $boolean
     * @return bool
     */
    public function isSuperUser($boolean = true)
    {
        return $this->hasRole(Role::SUPERUSER) == $boolean;
    }

    public function isAdmin($boolean = true)
    {
        return $this->hasRole(Role::ADMINISTRATOR) == $boolean;
    }

    public function isContentCreator($boolean = true)
    {
        return $this->hasRole(Role::CONTENT_CREATOR) == $boolean;
    }

    /**
     * @return RoleContract
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function setRoleID($integer)
    {
        $this->setAttribute('role_id', $integer);

        return $this;
    }

    public function status()
    {
        return $this->getAttribute('status') == null ? true : false;
    }

    /**
     * @param int $integer
     * @return $this
     */
    public function incrementLoginCount($integer = 1)
    {
        $this->setAttribute('login_count', ($this->loginCount() + $integer));

        return $this;
    }

    public function isVerified($boolean)
    {
        return $this->getAttribute('verified') == $boolean ? true : false;
    }

    public function setVerified($boolean)
    {
        $this->setAttribute('verified', $boolean);

        return $this;
    }

    /**
     * @return mixed
     */
    public function gravatarImageUrl()
    {
        return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email())));
    }

    /**
     * Collection of permissions this account has.
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->role->permissions;
    }

    /**
     * Check if the accounts current role matches the input role.
     * This should use static role ids from the role class.
     *
     * @param $role_id
     * @return bool
     * @throws \Exception
     */
    public function hasRole($role_id)
    {
        if (! is_numeric($role_id)) {
            throw new \Exception('An integer value must be passed to check for role hierarchy');
        }

        return $this->role->id() <= $role_id ? true : false;
    }

    /**
     * Check if the account has the required permission using the permission code
     * stored in the database.
     *
     * @param $code
     * @return bool
     */
    public function hasPermission($code)
    {
        if ($this->isSuperUser(true)) {
            return true;
        }

        return $this->role->permissions->where('code', $code)->first() ? true : false;
    }

    /**
     * Sometimes we want to check if our role is of a less value then what is
     * required, in this case we use the hasRoleAuthority method.
     *
     * @param $role_id
     * @return bool
     * @throws \Exception
     */
    public function hasRoleAuthority($role_id)
    {
        if (! is_numeric($role_id)) {
            throw new \Exception('An integer value must be passed to check for role hierarchy');
        }

        return $this->role->id() <= $role_id;
    }
}
