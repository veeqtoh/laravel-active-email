<?php

test('providers extend the base provider class')
    ->expect('Veeqtoh\ActiveEmail\Providers')
    ->classes()
    ->toExtend(\Illuminate\Support\ServiceProvider::class);