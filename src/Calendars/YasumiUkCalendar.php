<?php

namespace Worksome\UkTaxAllowance\Calendars;

use Carbon\Carbon;
use Worksome\UkTaxAllowance\Contracts\UkCalendar;
use Yasumi\Provider\AbstractProvider;
use Yasumi\Provider\UnitedKingdom;
use Yasumi\Yasumi;

class YasumiUkCalendar implements UkCalendar
{
    protected const FUTURE = 1;
    protected const PAST = -1;

    public function isWeekendDay(Carbon $date): bool
    {
        return $this->getCalendar($date)
                    ->isWeekendDay($date);
    }

    public function isHoliday(Carbon $date): bool
    {
        return $this->getCalendar($date)
                    ->isHoliday($date);
    }

    public function isWorkingDay(Carbon $date): bool
    {
        $ukCalendar = $this->getCalendar($date);

        return ! $ukCalendar->isWeekendDay($date)
               && ! $ukCalendar->isHoliday($date);
    }

    public function closestFuturWorkingDay(Carbon $date): Carbon
    {
        return $this->closestWorkingDay($date, self::FUTURE);
    }

    public function closestPastWorkingDay(Carbon $date): Carbon
    {
        return $this->closestWorkingDay($date, self::PAST);
    }

    protected function closestWorkingDay(Carbon $date, int $direction): Carbon
    {
        $workingDay = $date->copy();

        while (! $this->isWorkingDay($workingDay)) {
            $workingDay->addDays($direction);
        }

        return $workingDay;
    }

    private function getCalendar(Carbon $carbon): AbstractProvider
    {
        return Yasumi::create(UnitedKingdom::class, $carbon->year);
    }
}
