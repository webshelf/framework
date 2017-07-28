<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 14/09/2016
 * Time: 16:13.
 */

namespace App\Classes;

/**
 * Class Breadcrumbs.
 */
class Breadcrumbs
{
    /**
     * Should we limit the amount of crumbs we product on the crumb array.
     *
     * @var bool
     */
    private $limit = false;

    /**
     * Stored crumbs are placed in an array for use on blade template.
     *
     * @var array
     */
    private $crumbs = [];

    /**
     * Removed crumbs from array for whatever reason.
     *
     * @var array
     */
    private $removed = [];

    /**
     * Specify characters to find from urls or arrays and replace with.
     *
     * @var array
     */
    private $characters = ['find' => ['_', '-'], 'replace' => [' ', ' ']];

    /**
     * Convert a url stirng to a usable breadcrumb object array.
     *
     * @param $string
     * @return $this
     * @throws \Exception
     */
    public function parseUrlAsCrumbs($string)
    {
        $parsed_url = parse_url($string);

        $base_url = ($parsed_url['scheme'].'://'.$parsed_url['host']);

        if ($this->crumbs() == null) {
            $this->validateUrl($string);

            $this->addCrumb(new Breadcrumb('Home', $base_url));

            $sublinks = array_filter(explode('/', parse_url($string, PHP_URL_PATH)));

            $lastLink = end($sublinks);

            foreach ($sublinks as $key => $link) {
                $url = ($base_url .= '/'.strtolower($link));
                $title = ucwords(str_replace($this->characters['find'], $this->characters['replace'], $link));

                if ($link == $lastLink) {
                    $this->addCrumb(new Breadcrumb($title));
                } else {
                    $this->addCrumb(new Breadcrumb($title, $url));
                }
            }

            return $this;
        }

        throw new \Exception('You have already passed crumbs to this object for usage.');
    }

    /**
     * Gets the current url for the user and applies it to a crumb.
     *
     * @return Breadcrumbs
     */
    public function fromCurrentUrl()
    {
        return $this->parseUrlAsCrumbs(url()->current());
    }

    /**
     * Enter a url that is an addition to the current domain.
     *
     * @param $string
     * @return Breadcrumbs
     */
    public function fromRelativeUrl($string)
    {
        return $this->parseUrlAsCrumbs(url($string));
    }

    /**
     * A user entered domain name from scratch.
     *
     * @param $string
     * @return $this
     */
    public function fromAbsoluteUrl($string)
    {
        return $this->parseUrlAsCrumbs($string);
    }

    /**
     * Validate a url string is a valid url string.
     *
     * @param $string
     * @return $this
     * @throws \Exception
     */
    private function validateUrl($string)
    {
        if (gethostbyname($string)) {
            return $this;
        }

        throw new \Exception('The string passed was not a valid domain to use');
    }

    /**
     * Count the current crumbs that have been stored.
     *
     * @return int
     */
    public function count()
    {
        return count($this->crumbs);
    }

    /**
     * Return the objects crumbs that have been stored.
     *
     * @return array
     */
    public function crumbs()
    {
        foreach ($this->removed as $crumb) {
            $this->removeCrumb($crumb);
        }

        return $this->crumbs;
    }

    /**
     * Define if home should exist, this is bound to the preference settings
     * as of right now.
     *
     * @param $boolean
     * @return $this
     * @throws \Exception
     * @deprecated
     */
    public function homeExists($boolean)
    {
        if (is_bool($boolean)) {
            if ($boolean == false) {
                $this->removed['Home'] = $this->crumb('home');
            }

            return $this;
        }

        throw new \Exception('Property type is not of array value.');
    }

    /**
     * Remove a crumb from the object array.
     *
     * @param array $crumbs
     * @return $this
     * @throws \Exception
     */
    public function remove($crumbs = [])
    {
        if (is_array($crumbs)) {
            foreach ($crumbs as $name) {
                $this->removed[ucfirst($name)] = $this->crumb($name);
            }

            return $this;
        }

        throw new \Exception('Property is not of type array');
    }

    /**
     * Alter a crumbs title to something else.
     *
     * @param array $crumbs
     * @return $this
     */
    public function rename($crumbs = [])
    {
        foreach ($crumbs as $key => $value) {
            if ($this->keyExists($key)) {
                $this->changeCrumbTitle($this->crumb($key), $value);
            }
        }

        return $this;
    }

    /**
     * Check if the breadcrumb array contains a crumb name.
     *
     * @param $string
     * @param null $array_key
     * @return bool
     */
    public function contain($string, $array_key = null)
    {
        if ($array_key == null) {
            return $this->keyExists($string, $this->crumbs);
        } else {
            return $this->keyExists($string, $this->sliceKey($array_key));
        }
    }

    private function keyExists($key, $array = [])
    {
        if (empty($array)) {
            return array_key_exists(ucfirst($key), $this->crumbs);
        }

        return array_key_exists(ucfirst($key), $array);
    }

    private function sliceKey($key)
    {
        return array_slice($this->crumbs, ($key - 1), 1);
    }

    /**
     * Does this object has a home property allowed.
     *
     * @return bool
     */
    public function hasHome()
    {
        return ! $this->keyExists('home', $this->removed);
    }

    /**
     * Return a crumb by its key name from the object.
     *
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    private function crumb($name)
    {
        if ($this->keyExists($name)) {
            return $this->crumbs[ucfirst($name)];
        }

        throw new \Exception('Crumb name does not exist in the array.');
    }

    /**
     * Change the title of a crumb.
     *
     * @param Breadcrumb $breadcrumb
     * @param $string
     * @return Breadcrumb
     */
    private function changeCrumbTitle(Breadcrumb $breadcrumb, $string)
    {
        return $breadcrumb->setTitle($string);
    }

    /**
     * Add a new breadcrumb object to the crumbs array.
     *
     * @param Breadcrumb $breadcrumb
     * @return Breadcrumb
     */
    private function addCrumb(Breadcrumb $breadcrumb)
    {
        return $this->crumbs[$breadcrumb->title()] = $breadcrumb;
    }

    /**
     * Remove breadcrumb object from the crumbs array.
     *
     * @param Breadcrumb $breadcrumb
     * @param bool $boolean
     * @return $this
     */
    private function removeCrumb(Breadcrumb $breadcrumb, $boolean = true)
    {
        if ($boolean == true) {
            unset($this->crumbs[$breadcrumb->title()]);
        }

        return $this;
    }
}

/**
 * Class Breadcrumb.
 *
 * Singular objects for the breadcrumbs array.
 */
class Breadcrumb
{
    /**
     * The name of the breadcrumb.
     * @var
     */
    private $title;

    /**
     * The url of the breadcrumb.
     *
     * @var
     */
    private $url;

    /**
     * Create a new breadcrumb.
     *
     * Breadcrumb constructor.
     */
    public function __construct($title, $url = false)
    {
        $this->title = $title;

        $this->url = $url;
    }

    /**
     * Return breadcrumb title.
     *
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return breadcrumb url link.
     *
     * @return null
     */
    public function url()
    {
        return $this->url;
    }

    public function setTitle($string)
    {
        $this->title = ucfirst($string);

        return $this;
    }
}
