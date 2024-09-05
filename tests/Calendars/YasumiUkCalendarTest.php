<?php

namespace Worksome\UkTaxAllowance\Tests\Calendars;

use Illuminate\Support\Carbon;
use Worksome\UkTaxAllowance\Calendars\YasumiUkCalendar;

beforeEach(function () {
    $this->calendar = new YasumiUkCalendar();
});

it('returns correct closest past working day', function ($day, $expectedClosestPastWorkingDay) {
    $day = Carbon::createFromFormat('Y-m-d', $day);
    $closestPastWorkingDay = $this->calendar->closestPastWorkingDay($day);

    expect($closestPastWorkingDay->toDateString())->toEqual($expectedClosestPastWorkingDay);
})->with([
    ['2021-04-02', '2021-04-01'],
    ['2021-05-29', '2021-05-28'],
]);

it('returns correct closest future working day', function ($day, $expectedClosestFutureWorkingDay) {
    $day = Carbon::createFromFormat('Y-m-d', $day);
    $closestFutureWorkingDay = $this->calendar->closestFutureWorkingDay($day);

    expect($closestFutureWorkingDay->toDateString())->toEqual($expectedClosestFutureWorkingDay);
})->with([
    ['2021-04-02', '2021-04-06'],
    ['2021-05-29', '2021-06-01'],
]);
