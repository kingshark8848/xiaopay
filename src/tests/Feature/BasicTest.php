<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * test api root access
     *
     * @return void
     */
    public function testApiRootAccess()
    {
        $response = $this->get('/api/v1/');
        $response->assertStatus(200);
    }
}
