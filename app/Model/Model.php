<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 17/02/2018
 * Time: 23:30.
 */

namespace App\Model;

use \OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditContract;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Our Class Model to extend the Laravel Model.
 */
abstract class Model extends Eloquent implements AuditContract
{

    /**
     * Log the changes that occur on this model.
     */
    use AuditTrait;
}
