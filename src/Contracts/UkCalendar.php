<?php

namespace Worksome\UkTaxAllowance\Contracts;

use Carbon\Carbon;

interface UkCalendar
{
    public function isWeekendDay(Carbon $date): bool;

    public function isHoliday(Carbon $date): bool;

    public function isWorkingDay(Carbon $date): bool;

    public function closestFuturWorkingDay(Carbon $date): Carbon;

    public function closestPastWorkingDay(Carbon $date): Carbon;
}
