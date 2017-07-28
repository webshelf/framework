<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 16/10/2016
 * Time: 14:34.
 */

namespace App\Classes;

use Mail;
use App\Model\Account;

class Email
{
    public $from;
    /** @var Account */
    public $to;
    public $cc;
    public $bcc;
    public $header;
    public $subject;
    public $message;

    // store special items for the email to use.
    public $content = [];

    public function to(Account $account)
    {
        $this->to = $account;

        return $this;
    }

    public function header($message)
    {
        $this->header = $message;

        return $this;
    }

    public function from($email)
    {
        $this->from = $email;

        return $this;
    }

    public function subject($title)
    {
        $this->subject = $title;

        return $this;
    }

    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Attach a value to the email message.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function with($key, $value)
    {
        $this->content[$key] = $value;

        return $this;
    }

    public function send($view)
    {
        $from = $this->from ?: 'noreply@coffeebreakcms.com';
        $header = $this->header ?: 'Coffeebreak CMS';
        $this->to = $this->to ?: account();

        Mail::send($view, ['email' => $this], function ($m) use ($header, $from) {
            $m->from($from, $header);

            $m->to($this->to->email())->subject($this->subject." on '".tenant()->domain."'");
        });
    }
}
