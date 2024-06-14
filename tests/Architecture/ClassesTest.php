<?php

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

test('ActiveEmail validation class implements Laravel base validation rule class')
    ->expect('Veeqtoh\ActiveEmail\Rules\NotBlacklistedEmail')
    ->classes()
    ->toImplement(ValidationRule::class);

test('ActiveEmail provider class extends base Laravel service provider class')
    ->expect('Veeqtoh\ActiveEmail\Providers\ActiveEmailProvider')
    ->classes()
    ->toExtend(ServiceProvider::class);

test('ActiveEmail facade class extends base Laravel facade class')
    ->expect('Veeqtoh\ActiveEmail\Facades\ActiveEmail')
    ->classes()
    ->toExtend(Facade::class);