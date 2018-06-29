<?php

namespace Tests\Unit;

use App\Classes\StringGenerator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StringGeneratorTest extends TestCase
{
    /**
     * @return string
     */
    public function test_generator_can_create_username_from_email()
    {
        $string = "jacobi.roosevelt@example.net";

        $this->assertEquals("jacobi.roosevelt", StringGenerator::stripEmail($string));
    }

}
