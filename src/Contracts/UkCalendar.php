<?php

namespace Worksome\UkTaxAllowance\Contracts;

use Carbon\Carbon;

interface UkCalendar
{
    /**
     * Indicates if the provided date is a weekend day or not.
     */
    public function isWeekendDay(Carbon $date): bool;

    /**
     * Indicates if the provided date is a UK holiday or not.
     */
    public function isHoliday(Carbon $date): bool;

    /**
     * Indicates if the provided date is a working day (not a holiday nor a weekend day).
     */
    public function isWorkingDay(Carbon $date): bool;

    /**
     * Returns the closest working day in the future in comparison to the provided date.
     */
    public function closestFutureWorkingDay(Carbon $date): Carbon;

    /**
     * Returns the closest working day in the past in comparison to the provided date.
     */
    public function closestPastWorkingDay(Carbon $date): Carbon;

    /**
     * @deprecated Use closestFutureWorkingDay() instead.
     * @see closestFutureWorkingDay()
     */
    public function closestFuturWorkingDay(Carbon $date): Carbon;
}
