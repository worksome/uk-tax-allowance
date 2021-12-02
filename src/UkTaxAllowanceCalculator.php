<?php

namespace Worksome\UkTaxAllowance;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Worksome\UkTaxAllowance\Contracts\UkCalendar;

class UkTaxAllowanceCalculator
{
    protected const FUTURE = 1;
    protected const PAST = -1;

    public function __construct(private UkCalendar $calendar)
    {
    }

    /**
     * @return Collection<Carbon>
     */
    public function weeklyEndDatesBetween(Carbon $start, Carbon $end): Collection
    {
        $insideDates = collect(
            CarbonInterval::week()
                ->toPeriod($start, $end)
        )
            ->map(fn(Carbon $date) => $date->endOfWeek())
            ->reject(fn(Carbon $date) => $date->isAfter($end));

        $sundaysHovered = CarbonInterval::day()
            ->toPeriod($start, $end, CarbonPeriod::EXCLUDE_END_DATE)
            ->filter(fn(Carbon $carbon) => $carbon->isSunday());

        if ($sundaysHovered->count() >= $insideDates->count()) {
            $insideDates->push($end->copy());
        }

        return $insideDates;
    }

    /**
     * Returns the month end dates used for allowance count
     *
     * @return Collection<Carbon>
     */
    public function monthlyEndDatesBetween(Carbon $start, Carbon $end): Collection
    {
        $dateStart = $this->calendar->closestFuturWorkingDay($start);
        $dateEnd = $this->calendar->closestPastWorkingDay($end);

        if ($dateStart->isSameMonth($dateEnd)) {
            return collect([$dateEnd->copy()]);
        }

        $months = collect(
            CarbonInterval::day()
                ->toPeriod($dateStart, $dateEnd)
                ->filter(
                    fn(Carbon $day) => $day->isSameDay($this->lastWorkingDayOfTheMonth($day))
                )
        );

        if ($dateEnd->isBefore($this->lastWorkingDayOfTheMonth($dateEnd))) {
            $months->push($dateEnd->copy());
        }

        return $months;
    }

    public function weekly(Carbon $start, Carbon $end): int
    {
        return collect($this->weeklyEndDatesBetween($start, $end))->count();
    }

    public function monthly(Carbon $start, Carbon $end): int
    {
        // This counts the last months working days included in the period
        return $this->monthlyEndDatesBetween($start, $end)
            ->count();
    }

    public function lastWorkingDayOfTheMonth(Carbon $day): Carbon
    {
        return $this->calendar->closestPastWorkingDay(
            $day->copy()
                ->lastOfMonth()
        );
    }

    protected function isWorkingDay(Carbon $carbon): bool
    {
        return !$this->calendar->isWeekendDay($carbon)
            && !$this->calendar->isHoliday($carbon);
    }
}
