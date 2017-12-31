<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:20.
 */

namespace App\Classes\Library\PageLoader\Cordinators;

use App\Model\Page as Model;

/**
 * Class Page.
 */
class Page
{
    /**
     * @var Model
     */
    private $model;

    /**
     * Page constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->model->seo_title;
    }

    /**
     * @return string
     */
    public function title()
    {
        if (settings()->getValue('seo_text') != '') {
            if (settings()->getValue('seo_position') == 'right') {
                return ucfirst($this->model->seo_title).' '.settings()->getValue('seo_separator').' '.settings()->getValue('seo_separator');
            } else {
                return settings()->getValue('seo_text').' '.settings()->getValue('seo_separator').' '.ucfirst($this->model->seo_title);
            }
        } else {
            return ucfirst($this->model->seo_title);
        }
    }

    /**
     * @return mixed
     */
    public function keywords()
    {
        return $this->model->seo_keywords ?: settings()->getValue('page_keywords');
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return $this->model->seo_description ?: settings()->getValue('page_description');
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->model->content;
    }
}
