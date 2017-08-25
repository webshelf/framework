<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 07/01/2017
 * Time: 22:57.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Carousel.
 *
 * @property Image image
 * @property Account creator
 * @property Account editor
 */
class Carousel extends EloquentModel
{
    use SoftDeletes;

    protected $table = 'carousels';

    protected $softDeletes = true;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->getAttribute('id');
    }

    /**
     * @param int $integer
     * @return $this|Carousel
     */
    public function setID(int $integer) : self
    {
        return $this->setAttribute('id', $integer);
    }

    /**
     * @return string
     */
    public function title() : string
    {
        return $this->getAttribute('title');
    }

    /**
     * @param string $string
     * @return Carousel
     */
    public function setTitle(string $string) : self
    {
        return $this->setAttribute('title', $string);
    }

    /**
     * @return string
     */
    public function linkUrl() : string
    {
        return $this->getAttribute('link_url');
    }

    /**
     * @param string $string
     * @return Carousel
     */
    public function setLinkUrl(string $string) : self
    {
        return $this->setAttribute('link_url', $string);
    }

    /**
     * @return string
     */
    public function linkTarget() : string
    {
        return $this->getAttribute('link_target');
    }

    /**
     * @param string $string
     * @return Carousel
     */
    public function setLinkTarget(string $string) : self
    {
        return $this->setAttribute('link_target', $string);
    }

    /**
     * @return mixed
     */
    public function linkType()
    {
        return $this->getAttribute('link_type');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLinkType($value)
    {
        return $this->setAttribute('link_type', $value);
    }

    /**
     * @return int
     */
    public function orderID() : int
    {
        return $this->getAttribute('order_id');
    }

    /**
     * @param int $integer
     * @return Carousel
     */
    public function setOrderID(int $integer) : self
    {
        return $this->setAttribute('order_id', $integer);
    }

    /**
     * @return Image|mixed
     */
    public function image() : Image
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    /**
     * @param int $integer
     * @return Carousel
     */
    public function setImageID(int $integer) : self
    {
        return $this->setAttribute('image_id', $integer);
    }

    /**
     * @return Account|mixed
     */
    public function creator() : Account
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    /**
     * @param int $integer
     * @return Carousel
     */
    public function setCreatorID(int $integer) : self
    {
        return $this->setAttribute('creator_id', $integer);
    }

    /**
     * @return Account|mixed
     */
    public function editor() : Account
    {
        return $this->belongsTo(Account::class, 'editor_id', 'id');
    }

    /**
     * @param int $integer
     * @return Carousel
     */
    public function setEditorID(int $integer) : self
    {
        return $this->setAttribute('editor_id', $integer);
    }

    /**
     * @return mixed
     */
    public function deletedAt()
    {
        return $this->getAttribute('deleted_at');
    }

    /**
     * @return mixed
     */
    public function createdAt()
    {
        return $this->getAttribute('created_at');
    }

    /**
     * @return mixed
     */
    public function updatedAt()
    {
        return $this->getAttribute('updated_at');
    }
}
