# Worksome Uk Allowance library

[![Latest Version on Packagist](https://img.shields.io/packagist/v/worksome/uk-tax-allowance.svg?style=flat-square&label=Packagist)](https://packagist.org/packages/worksome/uk-tax-allowance)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/worksome/uk-tax-allowance/tests.yml?branch=main&style=flat-square&label=Tests)](https://github.com/worksome/uk-tax-allowance/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Static Analysis Action Status](https://img.shields.io/github/actions/workflow/status/worksome/uk-tax-allowance/static.yml?branch=main&style=flat-square&label=Static%20Analysis)](https://github.com/worksome/uk-tax-allowance/actions?query=workflow%3A"Static%20Analysis"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/worksome/uk-tax-allowance.svg?style=flat-square&label=Downloads)](https://packagist.org/packages/worksome/uk-tax-allowance)

This package is for determining a UK employee tax allowance for a specific date range. 

You may get the weekly or monthly tax allowance, as well as weekly or monthly period end dates for the provided date range.

## Installation

```shell
composer require worksome/uk-tax-allowance
```

## Usages

### `UkTaxAllowanceCalculator`

```php
/**
 * @param \Worksome\UkTaxAllowance\UkTaxAllowanceCalculator $ukTaxAllowanceCalculator
 * @param $dateStart \Carbon\Carbon
 * @param $dateEnd \Carbon\Carbon
 */
```

#### Weekly allowance

```php
// Get the weekly allowance count for a specific date range 
$weeklyAllowanceCount = $ukTaxAllowanceCalculator->weekly($dateStart, $dateEnd);

// Get the weekly allowance end dates for a specific date range 
$weeklyAllowanceEndDates = $ukTaxAllowanceCalculator->weeklyEndDatesBetween($dateStart, $dateEnd);
```

#### Monthly allowance

```php
// Get the monthly allowance end dates for a specific date range 
$monthlyAllowanceEndDates = $ukTaxAllowanceCalculator->monthlyEndDatesBetween($dateStart, $dateEnd);
// Get the monthly allowance count for a specific date range 
$monthlyAllowanceCount = $ukTaxAllowanceCalculator->monthly($dateStart, $dateEnd);
```

### Calendar

You may use our `YasumiUkCalendar` which relies on the [`azuyalabs/yasumi`](https://github.com/azuyalabs/yasumi) package. For Laravel users, `UkTaxAllowanceServiceProvider` will register it by default.

Or create your own and have it implement `Worksome\UkTaxAllowance\Contracts\UkCalendar`
