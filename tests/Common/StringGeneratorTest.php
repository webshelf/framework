<?php

namespace Tests\Common;

use Tests\TestCase;
use App\Classes\StringGenerator;

class StringGeneratorTest extends TestCase
{
    /**
     * @return string
     */
    public function test_generator_can_create_username_from_email()
    {
        $string = 'jacobi.roosevelt@example.net';

        $this->assertEquals('jacobi.roosevelt', StringGenerator::stripEmail($string));
    }
}
