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
    public $package = 'Webshelf';

    /**
     * The framework version number.
     *
     * @return string
     */
    public $version = '2.4.1';

    /**
     * The framework application website.
     *
     * @return string
     */
    public $website = '#';

    /**
     * The applications github repository.
     * Used for getting the app version.
     *
     * @return string
     */
    public $repository = 'webshelf/framework';

    /**
     * Get the latest github release for version checking.
     *
     * @return string
     */
    public function githubVersion()
    {
        return Github::latestReleaseVersion($this->repository) ?: 'unknown';
    }

    /**
     * Check if the framework is updated to the latest version.
     *
     * @return bool
     */
    public function isLatestVersion()
    {
        if (app()->isLocal()) {
            return true;
        }

        return $this->version != $this->githubVersion();
    }
}
