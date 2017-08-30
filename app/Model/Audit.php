<?php

namespace App\Model;

use App\Classes\Interfaces\AuditInterface;
use Carbon\Carbon;
use OwenIt\Auditing\Models\Audit as Auditing;

/**
 * Class Audit
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
 *
 * @package App
 */
class Audit extends Auditing
{

    public function action()
    {
        switch ($this->event) {
            case 'created': return 'created a new'; break;
            case 'deleted': return 'has deleted';   break;
        }
    }

    public function model()
    {
        return explode('\\', $this->auditable_type)[2];
    }
}
