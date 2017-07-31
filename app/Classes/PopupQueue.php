<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 14/11/2016
 * Time: 16:42.
 */

namespace App\Classes;

use Illuminate\Session\Store;

/**
 * Class PopupQueue.
 */
class PopupQueue
{
    const sessionVar = 'popups';

    /**
     * Notifications to appear on current load.
     *
     * @var array
     */
    private $popups = [];

    /**
     * @var \Request
     */
    public $session;

    /**
     * Add a new notification to the queue.
     *
     * @param Popup $popup
     * @return $this
     */
    public function add(Popup $popup)
    {
        $this->popups[$popup->getSerial()] = $popup;

        $this->syncSessionQueue();

        return $this;
    }

    public function setSession(Store $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @param Popup $popup
     * @return bool
     * @throws \Exception
     * @internal param $serial
     */
    public function remove(Popup $popup)
    {
        if (! is_null($this->popups[$popup->getSerial()])) {
            unset($this->popups[$popup->getSerial()]);
        }

        $this->syncSessionQueue();

        throw new \Exception('Popup serial could not be found for deletion.');
    }

    private function syncSessionQueue()
    {
        $this->session()->flash(self::sessionVar, $this->popups);
    }

    /**
     * @return Store|\Request
     */
    private function session()
    {
        if ($this->session) {
            return $this->session;
        }

        return request()->session();
    }

    /**
     * Check if any popups exist for viewing.
     *
     * @return bool
     */
    public function exist()
    {
        if(!$this->session)
            return false;

        return $this->session()->has(self::sessionVar);
    }

    /**
     * @return array
     */
    public function all()
    {
        return$this->session()->get(self::sessionVar);
    }
}
