<?php

namespace Worksome\UkTaxAllowance;

use Illuminate\Support\ServiceProvider;
use Worksome\UkTaxAllowance\Calendars\YasumiUkCalendar;
use Worksome\UkTaxAllowance\Contracts\UkCalendar;

class UkTaxAllowanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UkCalendar::class, function () {
            return new YasumiUkCalendar();
        });
    }
}
