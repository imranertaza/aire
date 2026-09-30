<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait ThrottlesFormRequests
{
    /**
     * Ensure that the current action has not exceeded its rate limit.
     *
     * @param string $action Action identifier (e.g. 'forgot-password', 'signup', 'signin')
     * @param int $maxAttempts Maximum allowed attempts
     * @param bool $byEmail Whether to include the email in the throttle key
     * @param string $field The input field name to attach the validation error to
     * @param string|null $customMessage Custom message (supports ':time' placeholder)
     * @throws ValidationException
     */
    public function ensureActionIsNotRateLimited(
        string $action,
        int $maxAttempts = 5,
        bool $byEmail = true,
        string $field = 'email',
        ?string $customMessage = null,
        ?callable $onLockout = null
    ): void {
        $key = $this->actionThrottleKey($action, $byEmail);

        if (! RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return;
        }

        if ($onLockout) {
            $onLockout($this);
        }

        $seconds = RateLimiter::availableIn($key);
        $timeStr = $seconds >= 60
            ? ceil($seconds / 60) . ' minute(s)'
            : "{$seconds} second(s)";

        $message = $customMessage
            ? str_replace(':time', $timeStr, $customMessage)
            : "Too many attempts. Please try again in {$timeStr}.";

        throw ValidationException::withMessages([
            $field => $message,
        ]);
    }

    /**
     * Increment the rate limiter attempts for the given action.
     *
     * @param string $action
     * @param int $decaySeconds
     * @param bool $byEmail
     */
    public function hitActionRateLimiter(string $action, int $decaySeconds = 60, bool $byEmail = true): void
    {
        RateLimiter::hit($this->actionThrottleKey($action, $byEmail), $decaySeconds);
    }

    /**
     * Clear the rate limiter attempts for the given action.
     *
     * @param string $action
     * @param bool $byEmail
     */
    public function clearActionRateLimiter(string $action, bool $byEmail = true): void
    {
        RateLimiter::clear($this->actionThrottleKey($action, $byEmail));
    }

    /**
     * Build the unique throttle key for the given action.
     *
     * @param string $action
     * @param bool $byEmail
     * @return string
     */
    public function actionThrottleKey(string $action, bool $byEmail = true): string
    {
        $email = $byEmail && $this->filled('email') ? Str::lower($this->input('email')) . '|' : '';

        return Str::transliterate("{$action}|{$email}{$this->ip()}");
    }
}
