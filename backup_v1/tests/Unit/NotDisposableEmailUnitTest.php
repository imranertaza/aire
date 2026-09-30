<?php

namespace Tests\Unit;

use App\Rules\NotDisposableEmail;
use Tests\TestCase;

class NotDisposableEmailUnitTest extends TestCase
{
    public function test_valid_emails_pass_disposable_rule(): void
    {
        $rule = new NotDisposableEmail();
        $validEmails = [
            'user@gmail.com',
            'contact@yahoo.com',
            'business@company.org',
            'john.doe@outlook.com',
        ];

        foreach ($validEmails as $email) {
            $failed = false;
            $rule->validate('email', $email, function () use (&$failed) {
                $failed = true;
            });
            $this->assertFalse($failed, "Failed for valid email: {$email}");
        }
    }

    public function test_disposable_emails_are_rejected(): void
    {
        $rule = new NotDisposableEmail();
        $disposableEmails = [
            'bot@mailinator.com',
            'spammer@tempmail.com',
            'test@10minutemail.com',
            'user@guerrillamail.com',
            'trash@yopmail.com',
            'fake@sharklasers.com',
        ];

        foreach ($disposableEmails as $email) {
            $failed = false;
            $errorMessage = '';
            $rule->validate('email', $email, function ($message) use (&$failed, &$errorMessage) {
                $failed = true;
                $errorMessage = $message;
            });
            $this->assertTrue($failed, "Did not reject disposable email: {$email}");
            $this->assertEquals('Disposable or temporary email addresses are not permitted.', $errorMessage);
        }
    }
}
