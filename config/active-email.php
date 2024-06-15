<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Strict Mode
    |--------------------------------------------------------------------------
    |
    | This value determines the strictness level of this feature.
    |
    */

    'strict_mode' => env('DISPOSABLE_EMAIL_STRICT_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Blacklist
    |--------------------------------------------------------------------------
    |
    | This is a list of base domains without the TLD that are blacklisted by
    | default. Add a domain to this list to blacklist it.
    |
    */

    'blacklist' => [
        // 
    ],

    /*
    |--------------------------------------------------------------------------
    | Greylist
    |--------------------------------------------------------------------------
    |
    | This is a list of base domains without the TLD that aren't blacklisted by
    | default except when in strict mode. Add a domain to this list to whitelist
    | it when the feature is not set to strict mode. Ensure that the domain is not
    | on the blacklist above.
    |
    */

    'greylist' => [
        // 
    ],

];
