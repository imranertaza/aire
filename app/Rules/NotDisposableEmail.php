<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotDisposableEmail implements ValidationRule
{
    /**
     * Common disposable, temporary, and throwaway email domains.
     *
     * @var array<int, string>
     */
    protected array $disposableDomains = [
        // 10 minute mail & temp mail domains
        '10minutemail.com',
        '10minutemail.net',
        '10minutemail.org',
        'tempmail.com',
        'tempmail.net',
        'tempmail.org',
        'temp-mail.org',
        'temp-mail.io',
        'disposablemail.com',
        'throwawaymail.com',
        'guerrillamail.com',
        'guerrillamail.net',
        'guerrillamail.org',
        'guerrillamail.biz',
        'guerrillamailblock.com',
        'sharklasers.com',
        'grr.la',
        'pokemail.net',
        'spam4.me',

        // Mailinator and aliases
        'mailinator.com',
        'mailinator.net',
        'mailinater.com',
        'suremail.info',
        'spamherelots.com',
        'binkmail.com',
        'safetymail.info',

        // Yopmail and aliases
        'yopmail.com',
        'yopmail.fr',
        'yopmail.net',
        'cool.fr.nf',
        'jetable.fr.nf',
        'courriel.fr.nf',
        'moncourrier.fr.nf',
        'monemail.fr.nf',
        'monmail.fr.nf',

        // Other popular disposable providers
        'trashmail.com',
        'trashmail.net',
        'trashmail.org',
        'getairmail.com',
        'dispostable.com',
        'fakeinbox.com',
        'generator.email',
        'maildrop.cc',
        'inboxkitten.com',
        'mohmal.com',
        'nada.ltd',
        'getnada.com',
        'emailondeck.com',
        'crazymailing.com',
        'mytemp.email',
        'burnermail.io',
        'minuteinbox.com',
        'tmpmail.net',
        'tmpmail.org',
        'discard.email',
        'discardmail.com',
        'spambog.com',
        'mytempemail.com',
        'fakemailgenerator.com',
        'armyspy.com',
        'cuvox.de',
        'dayrep.com',
        'einrot.com',
        'fleckens.hu',
        'gustr.com',
        'jourrapide.com',
        'rhyta.com',
        'superrito.com',
        'teleworm.us',
        'harakirimail.com',
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !str_contains($value, '@')) {
            return;
        }

        $parts = explode('@', $value);
        $domain = strtolower(trim(end($parts)));

        if ($domain && in_array($domain, $this->disposableDomains, true)) {
            $fail('Disposable or temporary email addresses are not permitted.');
        }
    }
}
