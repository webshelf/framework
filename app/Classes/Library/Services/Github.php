<?php

namespace App\Classes\Library\Services;

use Cache;

/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 22/03/2017
 * Time: 16:18.
 */
class Github
{
    /**
     * Get the latest release version.
     *
     * @param string $repository
     * @return string
     */
    public static function latestReleaseVersion(string $repository)
    {
        return Cache::remember('github_version', 20, function () use ($repository) {
            try {
                $agent = ['http' => ['method' => 'GET', 'header' => ['User-Agent: PHP']]];

                $stream = stream_context_create($agent);

                $releases = json_decode(file_get_contents('https://api.github.com/repos/'.$repository.'/tags', false, $stream));

                return $releases[0]->name;
            } catch (\ErrorException $e) {
                return '';
            }
        });
    }
}
