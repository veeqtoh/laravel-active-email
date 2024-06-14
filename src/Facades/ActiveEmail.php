<?php

declare(strict_types=1);

namespace Veeqtoh\ActiveEmail\Facades;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

/**
 * class ActiveEmail
 * This class provides the facade for this library.
 *
 * @package Veeqtoh\ActiveEmail\Facades
 */
class ActiveEmail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor() : string
    {
        return 'active-email';
    }
}
