<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 26/11/2016
 * Time: 14:29.
 */

namespace App\Classes\Library\Services;

use Spatie\Analytics\Period;
use Illuminate\Support\Collection;
use Spatie\Analytics\AnalyticsClientFactory;

/**
 * Class Analytics.
 */
class Analytics extends \Spatie\Analytics\Analytics
{
    /**
     * Analytics constructor.
     */
    public function __construct()
    {
        parent::__construct(AnalyticsClientFactory::createForConfig($this->settings()), $this->settings()['view_id']);
    }

    /**
     * Fetch the user count based on month by month period, we should default this to 0.
     *
     * @param  Period $period
     * @return Collection
     */
    public function fetchVisitorsByMonth(Period $period)
    {
        return \Cache::remember('monthly_visitors', 1440, function () use ($period) {
            try {
                $response = $this->performQuery($period,
                    'ga:users',
                    ['dimensions' => 'ga:month', 'max-results' => 5, 'sort' => '-ga:users']
                );

                $dates = [];

                foreach ($response['rows'] as $row) {
                    // do not show if it has no views.
                    if ($row[1] > 0) {
                        $dates[] = ['month'=> \DateTime::createFromFormat('!m', $row[0])->format('F'), 'users' =>$row[1]];
                    }
                }
            } catch (\Google_Service_Exception $e) {
                $dates[] = ['month'=> 'Unavailable', 'users' => 0];
            }

            return collect($dates);
        });
    }

    /**
     * The settings that will be used to generate the Analytics.
     *
     * @return array
     */
    private function settings()
    {
        return [
            /*
             * The view id of which you want to display data.
             */
            'view_id' => (int) settings()->getValue('google_project_id'),

            /*
             * Path to the json file with service account credentials. Take a look at the README of this package
             * to learn how to get this file.
             */
            'service_account_credentials_json' => __DIR__.'/Keys/analytics.json',

            /*
             * The amount of minutes the Google API responses will be cached.
             * If you set this to zero, the responses won't be cached at all.
             */
            'cache_lifetime_in_minutes' => 60 * 24,

            /*
             * The directory where the underlying Google_Client will store it's cache files.
             */
            'cache_location' => storage_path('google/'),
        ];
    }
}
