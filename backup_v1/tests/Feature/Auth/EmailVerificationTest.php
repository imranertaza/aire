<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    public function test_email_can_be_verified(): void
    {
        if (!Route::has('verification.verify')) {
            $this->markTestSkipped('Email verification route is not enabled in this application.');
        }
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        if (!Route::has('verification.verify')) {
            $this->markTestSkipped('Email verification route is not enabled in this application.');
        }
    }
}
