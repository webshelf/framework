<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 06/12/2017
 * Time: 00:59
 */

namespace Tests\Unit;

use App\Classes\Library\StyleCSS\Link;
use App\Classes\Library\StyleCSS\Status;
use App\Classes\Library\StyleCSS\Style;
use PHPUnit\Framework\TestCase;

/**
 * Class StyleTest
 *
 * @package Tests\Unit
 */
class StyleTest extends TestCase
{

    /**
     * @var Style
     */
    public $css;

    /**
     * Constructor
     */
    protected function setUp()
    {
        $this->css = new Style(new Status, new Link);
    }

    /**
     * @test
     */
    public function test_a_status()
    {
        $this->assertEquals('<i class="fa fa-sitemap green" aria-hidden="true"></i>', $this->css->status->sitemap(true));
        $this->assertEquals('<i class="fa fa-sitemap red" aria-hidden="true"></i>', $this->css->status->sitemap(false));
    }

    /**
     * @test
     */
    public function test_a_link()
    {
        $this->assertEquals('<a href="http://test.com"><i class="fa fa-pencil blue" aria-hidden="true"></i></a>', $this->css->link->edit('http://test.com'));
    }
}
