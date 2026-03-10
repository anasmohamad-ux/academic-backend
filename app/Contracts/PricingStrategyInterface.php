<?php
namespace App\Contracts;

use App\Models\Package;
use App\Models\Program;

interface PricingStrategyInterface
{
    public function calculate(Package $package, Program $program): float;
}