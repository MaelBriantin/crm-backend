<?php

namespace Tests\Unit;
use Carbon\Carbon;

test('checkDeferredDateStatus returns false for a date in the past', function () {
    $previousMonthDate = Carbon::now()->subMonth()->format('Y-m-d');

    $result = (new \App\Services\OrderService())->checkDeferredDateStatus($previousMonthDate);

    expect($result)->toBeFalse();
});

test('checkDeferredDateStatus returns true for a date in the future', function () {
    $nextMonthDate = Carbon::now()->addMonth()->format('Y-m-d');

    $result = (new \App\Services\OrderService())->checkDeferredDateStatus($nextMonthDate);

    expect($result)->toBeTrue();
});
