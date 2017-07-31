<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 27/08/2016
 * Time: 02:55.
 */

namespace App\Classes;

/**
 * Notifications allow the user to see messages on their screen.
 * To either inform them of errors, or of success.
 * This class will be the handler for all notifications and how they are represented.
 *
 * Class Notification
 */
class Popup
{
    /**
     * @var int
     */
    private $serial;

    /**
     * @var string
     */
    private $title;

    /**
     * The status of the notification message.
     * @var string
     */
    private $status;

    /**
     * The content of the notification message.
     * @var string
     */
    private $message;

    /**
     * Notification constructor.
     *
     * @param array $attributes
     * @internal param $message
     * @internal param null $title
     * @internal param null $id
     */
    public function __construct($attributes = [])
    {
        $this->message = isset($attributes['message']) ? $attributes['message'] : false;

        $this->title = isset($attributes['title']) ? $attributes['title'] : false;

        // create a unique id identifier.
        $this->serial = str_pad(rand(00000, 99999), 5, 0);
    }

    /**
     * Return the serial of the notification for usage later on.
     */
    private function store()
    {
        return $this;
    }

    /**
     * Notification success message.
     */
    public function success()
    {
        return $this->compose('Success!', 'success')->store();
    }

    /**
     * Notification information message.
     */
    public function info()
    {
        return $this->compose('Information!', 'info')->store();
    }

    /**
     * Notification error message.
     */
    public function error()
    {
        return $this->compose('Error!', 'error')->store();
    }

    /**
     * Notification warning message.
     */
    public function warning()
    {
        return $this->compose('Warning!', 'warning')->store();
    }

    /**
     * Compose a notification before storing.
     *
     * @param $title
     * @param $type
     * @return $this
     */
    private function compose($title, $type)
    {
        return $this->setTitle($title)->setMessage($this->message)->setType($type);
    }

    /**
     * Set the notification type.
     * This affects the way the notification looks.
     *
     * @param $string
     * @return $this
     */
    private function setType($string)
    {
        $this->status = $string;

        return $this;
    }

    /**
     * Set the notification title.
     *
     * @param $string
     * @return $this
     */
    private function setTitle($string)
    {
        $this->title = $this->title ?: $string;

        return $this;
    }

    /**
     * Set the message that will be displayed on the nomination body.
     * @param $text
     * @return $this
     */
    private function setMessage($text)
    {
        $this->message = $text;

        return $this;
    }

    /**
     * Get a property attribute from the class.
     *
     * @param $property
     * @return mixed
     */
    public function get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return false;
    }

    public function getSerial()
    {
        return $this->get('serial');
    }
}
