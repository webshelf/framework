<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/06/2016
 * Time: 23:17.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Image.
 */
class Image extends EloquentModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * @var bool
     */
    protected $softDelete = true;

    /**
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at', 'updated_at'];

    /**
     * Id of the image.
     *
     * @return int
     */
    public function id()
    {
        return $this->getAttribute('id');
    }

    /**
     * Stored filename, without extension.
     *
     * @return string
     */
    public function filename()
    {
        return $this->getAttribute('filename');
    }

    /**
     * Store file extension.
     *
     * @return string
     */
    public function extension()
    {
        return $this->getAttribute('extension');
    }

    /**
     * The directory in which the image is found.
     *
     * Relative to the website public folder.
     *
     * @return mixed
     */
    public function directory()
    {
        return $this->getAttribute('directory');
    }

    /**
     * Set the directory to where the image is found.
     *
     * Relative to the website public folder.
     *
     * @param $string
     * @return mixed
     */
    public function setDirectory($string)
    {
        $this->setAttribute('directory', $string);

        return $this;
    }

    /**
     * The size of the image in kb.
     *
     * @return int
     */
    public function size()
    {
        return $this->getAttribute('size');
    }

    /**
     * Viewing title.
     *
     * @return string
     */
    public function title()
    {
        return $this->getAttribute('title');
    }

    /**
     * Viewing description.
     *
     * @return string
     */
    public function description()
    {
        return $this->getAttribute('description');
    }

    /**
     * If this is made public.
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->getAttribute('published') ? true : false;
    }

    /**
     * The image uploader account.
     *
     * @return object AccountClass
     */
    public function uploader()
    {
        return $this->belongsTo(Account::class, 'uploader_id', 'id');
    }

    /**
     * The image modifier account.
     *
     * @return object AccountClass
     */
    public function modifier()
    {
        return $this->belongsTo(Account::class, 'modifier_id', 'id');
    }

    /**
     * Timestamp of deletion.
     *
     * @return string
     */
    public function deleted_at()
    {
        return $this->getAttribute('deleted_at');
    }

    /**
     * Timestamp of last updated.
     *
     * @return string
     */
    public function updated_at()
    {
        return $this->getAttribute('updated_at');
    }

    /**
     * Timestamp of first creation entry.
     *
     * @return string
     */
    public function created_at()
    {
        return $this->getAttribute('created_at');
    }

    /**
     * Name the models stored filename.
     *
     * @param $string
     * @return $this
     */
    public function setFilename($string)
    {
        $this->setAttribute('filename', $string);

        return $this;
    }

    /**
     * The stored file extension.
     *
     * @param $string
     * @return $this
     */
    public function setExtension($string)
    {
        $this->setAttribute('extension', $string);

        return $this;
    }

    /**
     * The stored file size in kb ?
     *
     * @param $integer
     * @return $this
     */
    public function setSize($integer)
    {
        $this->setAttribute('size', $integer);

        return $this;
    }

    /**
     * The stored file visual title.
     *
     * @param $string
     * @return $this
     */
    public function setTitle($string)
    {
        $this->setAttribute('title', $string);

        return $this;
    }

    /**
     * The file visual description.
     *
     * @param $string
     * @return $this
     */
    public function setDescription($string)
    {
        $this->setAttribute('description', $string);

        return $this;
    }

    /**
     * Set if this should be published to public.
     *
     * @param $boolean
     * @return $this
     */
    public function setPublished($boolean)
    {
        $this->setAttribute('published', $boolean);

        return $this;
    }
}
