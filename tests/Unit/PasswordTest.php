<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $user = User::where("username", "master")->first();
        $checkPassword = Hash::check("soliddd45", $user->password);
        $this->assertTrue($checkPassword);

    }
}
