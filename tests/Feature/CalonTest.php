<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->delete('/calon?Id=0190df21-4815-7172-8602-7856a0020abb');
        // $response = $this->get(route("calon.destroy", ["Id" => '0190df21-4815-7172-8602-7856a0020abb']));
        $response->assertStatus(200);
    }
}
