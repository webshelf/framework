<?php

namespace App\Model;

use Carbon\Carbon;
use App\Classes\Interfaces\AuditInterface;
use OwenIt\Auditing\Models\Audit as Auditing;

/**
 * Class Audit.
 *
 * @property int $id
 * @property int $user_id
 * @property string $event
 * @property int $auditable_id
 * @property string $auditable_type
 * @property array $old_values
 * @property array $new_values
 * @property string $url
 * @property string $ip_address
 * @property string $user_agent
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Account $user
 * @property AuditInterface $auditable
 */
class Audit extends Auditing
{

    public function afterActionVerb()
    {
        switch ($this->event) {
            case 'created': return 'created the'; break;
            case 'deleted': return 'deleted the'; break;
            case 'updated': return 'updated the'; break;
        }

        return false;
    }

    public function beforeActionVerb()
    {
        switch ($this->event) {
            case 'created': return 'was generated'; break;
            case 'deleted': return 'was destroyed'; break;
            case 'updated': return 'was modified'; break;
        }

        return false;
    }

    public function model()
    {
        return explode('\\', $this->auditable_type)[2];
    }
}
