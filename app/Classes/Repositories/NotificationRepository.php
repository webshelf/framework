<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 01/12/2016
 * Time: 14:58.
 */

namespace App\Classes\Repositories;

use App\Model\Notification;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class NotificationRepository.
 */
class NotificationRepository
{
    /**
     * The model for eloquent access.
     *
     * @var Builder
     */
    private $model;

    /**
     * AccountRepository constructor.
     *
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    /**
     * Return a collection of all available notifications for the application and the user.
     */
    public function all() : Collection
    {
        return $this->model->orderBy('created_at', 'desc')->where('account_id', null)->orWhere('account_id', account()->id())->limit(15)->get();
    }

    /**
     * Return a collection of all unread notifications for the application and the user.
     */
    public function unread() : Collection
    {
        return $this->model->where(['read_at'=>null, 'account_id'=>null])->orderBy('created_at', 'desc')->orWhere(['read_at'=>null, 'account_id'=>account()->id()])->limit(15)->get();
    }

    /**
     * Return a collection of all read notifications for the application and user.
     */
    public function read() : Collection
    {
        return $this->model->whereNotNull('read_at')->orderBy('created_at', 'desc')->where('account_id', null)->orWhere('account_id', account()->id())->limit(15)->get();
    }
}
