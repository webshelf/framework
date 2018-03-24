<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 17/02/2018
 * Time: 23:30
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @property int $editor_id
 * @property int $creator_id
 *
 * @property Account $editor
 * @property Account $creator
 *
 * @package App\Model
 */
abstract class BaseModel extends Model
{

    /**
     * Keep track of editor and creator.
     *
     * @return bool
     * @throws \Exception
     */
    public function auditSave()
    {
        if (method_exists($this, 'creator' || method_exists($this, 'editor'))) {
            throw new \Exception("Methods 'creator()' & 'editor()' must exist to use auditSave() in {$this->getMorphClass()}");
        }

        if (!$this->creator) {
            $this->setAttribute('creator_id', account()->id);
        }

        $this->setAttribute('editor_id', account()->id);

        return $this->save();
    }

}