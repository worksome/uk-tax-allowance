<?php

use Carbon\Carbon;
use Worksome\UkTaxAllowance\UkTaxAllowanceCalculator;

uses()
    ->beforeEach(function () {
        $this->taxAllowanceCalculator = $this->app->make(UkTaxAllowanceCalculator::class);
    });

it('returns valid week end dates', function ($start, $end, $endDates) {
    $start = Carbon::createFromFormat('Y-m-d', $start)
        ->startOfDay();
    $end = Carbon::createFromFormat('Y-m-d', $end)
        ->startOfDay();

    $weeklyEndDates = collect($this->taxAllowanceCalculator->weeklyEndDatesBetween($start, $end))
        ->map(fn (Carbon $carbon) => $carbon->toDateString())
        ->all();

    expect($weeklyEndDates)->toEqual($endDates);
})->with([
    // Start     |   End       | Expected list of end dates
    ['2021-04-01', '2021-04-03', ['2021-04-03']],
    // less than a week
    ['2021-04-03', '2021-04-06', ['2021-04-04', '2021-04-06']],
    // less than a week over two weeks
    ['2021-04-05', '2021-04-05', ['2021-04-05']],
    // one monday
    ['2021-04-04', '2021-04-04', ['2021-04-04']],
    // one sunday
    ['2021-04-01', '2021-04-04', ['2021-04-04']],
    // less than a week ending on a sunday
    ['2021-04-05', '2021-04-10', ['2021-04-10']],
    // one perfect week
    ['2021-04-01', '2021-04-07', ['2021-04-04', '2021-04-07']],
    // 7 days over two weeks
    ['2021-04-05', '2021-04-25', ['2021-04-11', '2021-04-18', '2021-04-25']],
    // 3 perfect weeks
    ['2021-04-06', '2021-04-27', ['2021-04-11', '2021-04-18', '2021-04-25', '2021-04-27']],
    // 21 days over 4 weeks
    ['2021-04-04', '2021-04-27', ['2021-04-04', '2021-04-11', '2021-04-18', '2021-04-25', '2021-04-27']],
    // 23 days over 5 weeks and starting on a sunday (why not ?)
    [
        '2021-04-01',
        '2021-05-31',
        [
            '2021-04-04',
            '2021-04-11',
            '2021-04-18',
            '2021-04-25',
            '2021-05-02',
            '2021-05-09',
            '2021-05-16',
            '2021-05-23',
            '2021-05-30',
            '2021-05-31',
        ],
    ],
    // Full April to May
]);

it('returns valid weekly allowance intervals', function ($start, $end, $allowance) {
    $start = Carbon::createFromFormat('Y-m-d', $start)
        ->startOfDay();
    $end = Carbon::createFromFormat('Y-m-d', $end)
        ->startOfDay();

    expect($this->taxAllowanceCalculator->weekly($start, $end))->toEqual($allowance);
})->with([
    // Start date   | End date   | Expected allowance count
    ['2021-04-01', '2021-04-03', 1], // less than a week
    ['2021-04-03', '2021-04-06', 2], // less than a week over two weeks
    ['2021-04-05', '2021-04-05', 1], // one monday
    ['2021-04-04', '2021-04-04', 1], // one sunday
    ['2021-04-01', '2021-04-04', 1], // less than a week ending on a sunday
    ['2021-04-05', '2021-04-10', 1], // one perfect week
    ['2021-04-01', '2021-04-07', 2], // 7 days over two weeks
    ['2021-04-05', '2021-04-25', 3], // 3 perfect weeks
    ['2021-04-06', '2021-04-27', 4], // 21 days over 4 weeks
    ['2021-04-04', '2021-04-27', 5], // 23 days over 5 weeks and starting on a sunday (why not ?)
    ['2021-04-01', '2021-05-31', 10], // Full April to May
]);

it('returns valid month end dates', function ($start, $end, $endDates) {
    $start = Carbon::createFromFormat('Y-m-d', $start)
        ->startOfDay();
    $end = Carbon::createFromFormat('Y-m-d', $end)
        ->startOfDay();
    $monthEndDates = $this->taxAllowanceCalculator->monthlyEndDatesBetween($start, $end)
        ->map(fn (Carbon $carbon) => $carbon->toDateString())
        ->all();

    expect($monthEndDates)->toEqual($endDates);
})->with([
    // Start     |   End       | Expected list of end dates
    ['2021-04-01', '2021-04-03', ['2021-04-01']],
    ['2021-04-01', '2021-04-30', ['2021-04-30']],
    ['2021-04-01', '2021-05-10', ['2021-04-30', '2021-05-10']],
    [
        '2021-04-01',
        '2021-09-02',
        ['2021-04-30', '2021-05-28', '2021-06-30', '2021-07-30', '2021-08-31', '2021-09-02'],
    ],
    ['2021-04-30', '2021-06-02', ['2021-04-30', '2021-05-28', '2021-06-02']],
    ['2021-04-25', '2021-05-05', ['2021-04-30', '2021-05-05']],
    ['2021-04-05', '2021-05-02', ['2021-04-30']],
    ['2021-04-01', '2021-08-01', ['2021-04-30', '2021-05-28', '2021-06-30', '2021-07-30']],
    ['2021-07-31', '2021-08-01', []],
    ['2021-05-31', '2021-06-10', ['2021-06-10']],
]);

it('returns valid monthly allowance intervals', function ($start, $end, $allowance) {
    $start = Carbon::createFromFormat('Y-m-d', $start)
        ->startOfDay();
    $end = Carbon::createFromFormat('Y-m-d', $end)
        ->startOfDay();

    expect($this->taxAllowanceCalculator->monthly($start, $end))->toEqual($allowance);
})->with([
    // Start date   | End date   | Expected allowance count
    ['2021-04-01', '2021-04-03', 1],
    // less than a month
    ['2021-04-01', '2021-04-30', 1],
    // one perfect month
    ['2021-04-01', '2021-05-10', 2],
    // over two month, start on first and ending fine
    ['2021-04-01', '2021-09-02', 6],
    // over 6 months
    ['2021-04-30', '2021-06-02', 3],
    // over 6 months
    ['2021-04-25', '2021-05-05', 2],
    // less than a month length over two months
    ['2021-04-05', '2021-05-02', 1],
    // over two months, starting fine but ending on the first days of next month which are weekends
    ['2021-04-01', '2021-08-01', 4],
    // over 5 month but ending on first day being a non-working day, so 4 allowance
    ['2021-07-31', '2021-08-01', 0],
    // over 2 month but starting and ending on the same weekend..., so 0 allowance
    ['2021-05-31', '2021-06-10', 1],
    // over 2 month but starting on last day being a non-working day, so 1 allowance
]);
