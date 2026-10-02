<?php

use Illuminate\Support\Facades\Artisan;

it('prunes passes once a day so the app can hibernate', function () {
    Artisan::call('schedule:list');

    expect(Artisan::output())->toMatch('/0 3 \* \* \*\s+php artisan passes:prune/');
});
