<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {

        $user = DB::table('users')->where("username", "master")->first();
        $checkPassword = Hash::check("soliddd45", $user->password);
        $this->assertTrue($checkPassword);

    }
}
