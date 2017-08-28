<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 28/08/2017
 * Time: 07:26
 */

namespace App\Classes\Interfaces;

use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

interface AuditInterface extends AuditableContract
{

    /**
     * Generate a link for the audit log.
     *
     * @return string
     */
    public function auditTitle();

}