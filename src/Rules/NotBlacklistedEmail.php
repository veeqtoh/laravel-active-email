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
    public function __construct(protected DisposableEmail $disposableEmail)
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $domain     = $this->getDomainName('@', $value, 1);
        $domainName = $this->getDomainName('.', $domain, 0);

        $mergedBlackLists       = array_merge(config('active-email.blacklist'), $this->disposableEmail->getBlacklist());
        $blackListedDomainNames = array_unique($mergedBlackLists);

        $mergedGreyLists       = array_merge(config('active-email.greylist'), $this->disposableEmail->getGreyList());
        $greyListedDomainNames = array_unique($mergedGreyLists);

        if (config('active-email.strict_mode')) {
            $blackListedDomainNames = array_merge($blackListedDomainNames, $greyListedDomainNames);
        }

        foreach ($blackListedDomainNames as $blacklistedDomainName) {
            $disposable = $this->getDomainName('.', $blacklistedDomainName, 0);

            if ($domainName === $disposable) {
                $fail('Sorry, your email provider is not supported. If you think this is in error, please email support.');

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
        return explode($separator, $input)[$position];
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
