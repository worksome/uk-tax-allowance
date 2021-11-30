<?php

namespace Worksome\UkTaxAllowance\Contracts;

use Carbon\Carbon;

interface UkCalendar
{
    /**
     * Indicates if a Carbon $date is a weekend day or not
     */
    public function isWeekendDay(Carbon $date): bool;

    /**
     * Indicates if a Carbon $date is a uk holiday or not
     */
    public function isHoliday(Carbon $date): bool;

    /**
     * Indicates if a Carbon $date is a working day (not a holiday nor a weekend day)
     */
    public function isWorkingDay(Carbon $date): bool;

    /**
     * Returns the closest working day in the future in comparaison to the passed Carbon $date
     */
    public function closestFuturWorkingDay(Carbon $date): Carbon;

    /**
     * Returns the closest working day in the past in comparaison to the passed Carbon $date
     */
    public function closestPastWorkingDay(Carbon $date): Carbon;
}
