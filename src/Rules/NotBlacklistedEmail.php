<?php

declare(strict_types=1);

namespace Veeqtoh\ActiveEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Veeqtoh\ActiveEmail\DisposableEmail;

/**
 * class NotBlacklistedEmail
 * This library that validates an email.
 *
 * @package Veeqtoh\ActiveEmail\Rules
 */
class NotBlacklistedEmail implements ValidationRule
{
    /**
     * Constructor to initialize the blacklisted domain names from the disposable class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute The name of the attribute being validated.
     * @param mixed  $value     The value of the attribute being validated.
     * @param \Closure(mixed): \Illuminate\Translation\PotentiallyTranslatedString $fail
     *                          The callback that should be used to report validation failures.
     *
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $disposableEmail = new DisposableEmail();

        $domain     = $this->getDomainName('@', $value, 1);
        $domainName = $this->getDomainName('.', $domain, 0);

        $blackListedDomainNames = array_unique(array_merge(config('active-email.blacklist'), $disposableEmail->getBlacklist()));
        $greyListedDomainNames  = array_unique(array_merge(config('active-email.greylist'), $disposableEmail->getGreyList()));
        $whiteListedDomainNames = array_unique(config('active-email.whitelist'));

        foreach ($whiteListedDomainNames as $whiteListedDomainName) {
            $byePass = $this->getDomainName('.', $whiteListedDomainName, 0);

            if ($domainName === $byePass) {
                return;
            }
        }

        if (config('active-email.strict_mode')) {
            $blackListedDomainNames = array_merge($blackListedDomainNames, $greyListedDomainNames);
        }

        foreach ($blackListedDomainNames as $blacklistedDomainName) {
            $disposable = $this->getDomainName('.', $blacklistedDomainName, 0);

            if ($domainName === $disposable) {
                $failMessage = config('active-email.error_message');
                $fail($failMessage ? $failMessage : 'Sorry, your email provider is not supported. If you think this is an error, please contact us.');

                return;
            }
        }
    }

    /**
     * Retrieve the domain name from a given string.
     *
     * @param string $separator The boundary string.
     * @param string $input     The input string.
     * @param int    $position  The position of the array to be returned.
     *
     * @return string
     */
    protected function getDomainName(string $separator, string $input, int $position) : string
    {
        return explode($separator, strtolower($input))[$position];
    }

    /**
     * Rule documentation for Scribe.
     */
    public static function docs() : array
    {
        return [
            'description' => 'The email must be from a trusted provider.',
            'example'     => 'google.com',
        ];
    }
}
