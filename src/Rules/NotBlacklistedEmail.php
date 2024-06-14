<?php

declare(strict_types=1);

namespace Veeqtoh\ActiveEmail\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotBlacklistedEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $domain     = $this->getDomainName('@', $value, 1);
        $domainName = $this->getDomainName('.', $domain, 0);

        $blackListedDomainNames = config('disposable.blacklist');
        if (config('disposable.strict_mode')) {
            $blackListedDomainNames = array_merge(config('disposable.blacklist'), config('disposable.greylist'));
        }

        foreach ($blackListedDomainNames as $blacklistedDomainName) {
            $disposable = $this->getDomainName('.', $blacklistedDomainName, 0);

            if ($domainName === $disposable) {
                $fail('Sorry, your :attribute provider is not supported. If you think this is in error, please email support.');

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
