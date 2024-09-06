<?php

namespace Worksome\UkTaxAllowance;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Worksome\UkTaxAllowance\Calendars\YasumiUkCalendar;
use Worksome\UkTaxAllowance\Contracts\UkCalendar;

class UkTaxAllowanceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(UkCalendar::class, function () {
            return new YasumiUkCalendar();
        });
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [UkCalendar::class];
    }
}
