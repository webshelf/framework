<?php

namespace App\Model;

/**
 * Class Activity.
 *
 * @property int $id
 * @property string $ip_address
 * @property string $email
 * @property string $message
 * @property Account $account
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @method AccessLog belongingTo
 * @method AccessLog byMessage
 */
class AccessLog extends Model
{
    /**
     * Login was good logged.
     */
    const LOGIN_STATUS_SUCCESS = 'Login ok.';

    /**
     * Login attempt was logged.
     */
    const LOGIN_STATUS_FAILED = 'Incorrect Password.';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'backend_access_log';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The model belongsTo Relations.
     *
     * @var array Model Relations
     */
    public $belongsTo = ['account' => Account::class];

    /**
     * Undocumented function.
     *
     * @param Builder $query Laravel Model Builder.
     * @return void
     */
    public function scopeBelongingTo($query, Account $account)
    {
        return $query->where('email', $account->email);
    }

    /**
     * Scope the query down to a message entry.
     *
     * @param Builder $query Laravel Model Builder.
     * @param string $message The comaprison constant
     * @return Builder Laravel Model Builder.
     */
    public function scopeByMessage($query, string $message)
    {
        return $query->where('message', $message);
    }

    /**
     * Get the latest attempt from the account.
     *
     * @param Account $account
     * @return Account The latest log entry of the account model.
     */
    public static function latestAttemptFrom(Account $account)
    {
        return self::belongingTo($account)->latest()->take(1)->first();
    }

    /**
     * Get the total attemps made on the account since the last login occured,.
     *
     * @param Account $account The account to retrieve logs from.
     * @return int The total count of failed login attempts.
     */
    public static function getAttemptsToLogin(Account $account)
    {
        return 0;
    }

    /**
     * Generate a log entry for the database table.
     *
     * @param string $email
     * @param string $ip_address
     * @param string $message
     * @return void
     */
    public static function generateLog(string $email, string $ip_address, string $message)
    {
        return self::create(['email' => $email, 'ip_address' => $ip_address, 'message' => $message]);
    }
}
