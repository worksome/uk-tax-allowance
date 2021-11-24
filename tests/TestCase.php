<?php

namespace Worksome\UkTaxAllowance\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Worksome\UkTaxAllowance\UkTaxAllowanceServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [UkTaxAllowanceServiceProvider::class];
    }
}
