<?php

declare(strict_types=1);

namespace Veeqtoh\ActiveEmail\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Veeqtoh\ActiveEmail\Rules\NotBlacklistedEmail;

/**
 * class ActiveEmailProvider
 * This class registers the package within Laravel.
 *
 * @package Veeqtoh\ActiveEmail\Providers
 */
class ActiveEmailProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register() : void
    {
        // Merge the package configuration with the Laravel application's configuration.
        $this->mergeConfigFrom(__DIR__ . '/../../config/active-email.php', 'active-email');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() : void
    {
        // Publish the package configuration file to the Laravel application.
        $this->publishes([
            __DIR__ . '/../../config/active-email.php' => config_path('active-email.php'),
        ], 'config');

        // Register the custom validation rule
        Validator::extend('notblacklisted', function ($attribute, $value, $parameters, $validator) {
            $rule = new NotBlacklistedEmail();

            // Create a Closure for the fail method
            $fail = function($message) use ($attribute, $validator) {
                $validator->errors()->add($attribute, $message);
            };

            $rule->validate($attribute, $value, $fail);

            return !$validator->errors()->has($attribute);
        });
    }
}
