<?php

namespace Veeqtoh\ActiveEmail\Tests\Unit;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Veeqtoh\ActiveEmail\Facades\ActiveEmail;
use Veeqtoh\ActiveEmail\Providers\ActiveEmailProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ActiveEmailProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'ActiveEmail' => ActiveEmail::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Set up any necessary configurations here
        $app['config']->set('disposable.blacklist', ['mailinator.com', 'tempmail.com', 'example.ltd', 'example.co', 'example.com.nh', 'example.co.uk']);
        $app['config']->set('disposable.greylist', []);
        $app['config']->set('disposable.strict_mode', false);
    }
}
