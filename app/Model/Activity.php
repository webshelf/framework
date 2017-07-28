<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/09/2016
 * Time: 10:44.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Interfaces\ActivityInterface;

/**
 * Class Activity.
 *
 * @method ActivityInterface $activity
 */
class Activity extends Engine
{
    /**
     * The table where this activity model is stored.
     *
     * @var string
     */
    protected $table = 'activity_log';

    /*
     * Soft Deleting
     */
    use SoftDeletes;

    protected $softDeletes = true;

    public static $interactions = [
        'modified' => 1,
        'deleted'  => 2,
        'created'  => 3,
    ];

    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public function action()
    {
        return array_first(array_keys(self::$interactions, $this->getAttribute('interaction_id')));
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * @throws  \Exception
     */
    public function activity()
    {
        $controller = 'App\Model\\'.ucfirst($this->getAttribute('activity_type'));

        if ((new $controller) instanceof ActivityInterface) {
            return $this->belongsTo($controller, 'activity_id', 'id')->withTrashed();
        }

        throw new \Exception($controller.' is not an instance of the activity interaction interface and must be implemented');
    }

    /**
     * Call the classes activity interaction title.
     *
     * @return  mixed
     */
    public function title()
    {
        return $this->activity->feed_title();
    }

    /**
     * call the classes activity interaction link.
     *
     * @return  mixed
     */
    public function link()
    {
        if (! $this->activity->feed_url()) {
            return;
        }

        return $this->activity->feed_url();
    }

    public function activity_name()
    {
        return $this->getAttribute('activity_type');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    public function interactionID()
    {
        return $this->getAttribute('interaction_id');
    }

    public function setInteractionID($integer)
    {
        $this->setAttribute('interaction_id', $integer);

        return $this;
    }

    public function setActivityType($string)
    {
        $this->setAttribute('activity_type', $string);

        return $this;
    }

    public function setActivityID($integer)
    {
        $this->setAttribute('activity_id', $integer);

        return $this;
    }

    public function setAccount(int $account_id)
    {
        $this->setAttribute('account_id', $account_id);

        return $this;
    }

    public function isInteraction(int $interaction)
    {
        return $this->interactionID() === $interaction;
    }
}
