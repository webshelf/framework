<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 29/07/2017
 * Time: 00:03
 */

namespace Tests\Feature;

use App\Model\Account;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BackendLoadingTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * @test
     */
    public function file_manager_standalone()
    {
        auth()->loginUsingId(1);

        $status = $this->get('/admin/filemanager')->getStatusCode();

        $this->assertEquals(200, $status);
    }

}
