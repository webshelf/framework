<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/02/2017
 * Time: 02:41.
 */

namespace App;

use App\Classes\Library\Services\Github;

/**
 * Class Framework.
 */
class Framework
{
    /**
     * The framework application name.
     *
     * @return string
     */
    private $package = 'Webshelf';

    /**
     * The framework version number.
     *
     * @return string
     */
    private $version = '2.1.1';

    /**
     * The framework application website.
     *
     * @return string
     */
    private $website = '#';

    /**
     * The applications github repository.
     * Used for getting the app version.
     *
     * @return string
     */
    private $repository = 'webshelf/framework';


    /**
     * Get the package name, this is in case it ever changes.
     *
     * @return string
     */
    public function packageName()
    {
        return $this->package ?: 'unknown';
    }

    /**
     * Get the website url address that users can visit.
     *
     * @return string
     */
    public function websiteUrl()
    {
        return $this->website;
    }

    /**
     * Get the latest version of the current webshelf app.
     *
     * @return string
     */
    public function currentRelease()
    {
        return $this->version ?: 'unknown';
    }

    /**
     * Get the latest github release for version checking.
     *
     * @return string
     */
    public function latestRelease()
    {
        return Github::latestReleaseVersion($this->repository) ?: 'unknown';
    }

    /**
     * Check if the framework is updated to the latest version.
     *
     * @return bool
     */
    public function isLatestRelease()
    {
        if(app()->isLocal())
            return true;

        return ($this->currentRelease() != $this->latestRelease());
    }
}
