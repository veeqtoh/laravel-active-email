<?php

use Illuminate\Support\Facades\Validator;
use Veeqtoh\ActiveEmail\Rules\NotBlacklistedEmail;

it('validates that emails are not from blacklisted domains', function () {
    $rule = ['email' => [new NotBlacklistedEmail]];

    // Valid email addresses (not blacklisted).
    $validEmails = [
        'user@gmail.com',
        'user@yahoo.com',
        'user@customdomain.org',
    ];

    foreach ($validEmails as $email) {
        $validator = Validator::make(['email' => $email], $rule);
        expect($validator->passes())->toBeTrue();
    }

    // Invalid email addresses (blacklisted domains).
    $invalidEmails = [
        'user@mailinator.com',
        'user@tempmail.com',
        'user@example.ltd',
        'user@example.co',
        'user@example.com.nh',
        'user@example.co.uk',
    ];

    foreach ($invalidEmails as $email) {
        $validator = Validator::make(['email' => $email], $rule);
        expect($validator->fails())->toBeTrue();
    }
});