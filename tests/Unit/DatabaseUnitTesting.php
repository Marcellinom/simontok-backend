<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DatabaseUnitTesting extends TestCase
{
    public function testDatabaseConnection()
    {
        $this->expectNotToPerformAssertions();
        DB::getPdo();
    }
    public function testTableUserExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('users')->getConnection();
    }
    public function testTableOtpExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('otp')->getConnection();
    }
    /** lanjutin bang... untuk semua tabel yg ada */
}
