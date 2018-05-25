<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 10/12/2016
 * Time: 22:45.
 */

namespace Tests\Unit;

use App\Classes\ReadTime;
use PHPUnit\Framework\TestCase;

/**
 * Application testing of storage of settings.
 *
 * Class SettingsTest
 */
class ReadTimeTest extends TestCase
{
    public function test_word_estimate_time()
    {
        $string = 'This is an example word string for testing on PHPUnit test suite.';

        $this->assertEquals(1, ReadTime::InMinutes($string));
    }

    public function test_word_count()
    {
        $string = 'This is an example word string for testing on PHPUnit test suite.';

        $this->assertEquals(12, ReadTime::countWords($string));
    }
}
