# Worksome Uk Allowance library

[![Tests](https://github.com/worksome/uk-tax-allowance/actions/workflows/main.yml/badge.svg)](https://github.com/worksome/uk-tax-allowance/actions/workflows/main.yml)
[![Code Analysis](https://github.com/worksome/uk-tax-allowance/actions/workflows/code-analysis.yml/badge.svg)](https://github.com/worksome/uk-tax-allowance/actions/workflows/code-analysis.yml)

This package is for determining a UK employee tax allowance for a specific date range. 

You may get weekly or monthly number of allowance, as well as weekly or monthly period end dates for the provided date range.

## Installation

```shell
composer require worksome/uk-tax-allowance
```

## Usages

### UkTaxAllowanceCalculator

```php
/**
 * @param \Worksome\UkTaxAllowance\UkTaxAllowanceCalculator $ukTaxAllowanceCalculator
 * @param $dateStart \Carbon\Carbon
 * @param $dateEnd \Carbon\Carbon
 */
```

#### Weekly allowance

```php
// Get weekly allowance count for a specific date range 
$weeklyAllowanceCount = $ukTaxAllowanceCalculator->weekly($dateStart, $dateEnd);

// Get weekly allowance end dates for a specific date range 
$weeklyAllowanceEndDates = $ukTaxAllowanceCalculator->weeklyEndDatesBetween($dateStart, $dateEnd);
```

#### Monthly allowance
```php
// Get monthly allowance end dates for a specific date range 
$monthlyAllowanceEndDates = $ukTaxAllowanceCalculator->monthlyEndDatesBetween($dateStart, $dateEnd);
// Get monthly allowance count for a specific date range 
$monthlyAllowanceCount = $ukTaxAllowanceCalculator->monthly($dateStart, $dateEnd);
```

### Calendar

You may use our YasumiUkCalendar which relies on the yasumi/yasumi packages. For Laravel users, `UkTaxAllowanceServiceProvider` will register it by default.

Or create your own and have it implement `Worksome\UkTaxAllowance\Contracts\UkCalendar`
