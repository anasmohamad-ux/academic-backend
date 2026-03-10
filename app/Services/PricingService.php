<?php
namespace App\Services;

use App\Contracts\PricingStrategyInterface;
use App\Models\Package;
use App\Models\Program;
use Illuminate\Support\Collection;

class PricingService implements PricingStrategyInterface
{

    public function calculate(Package $package, Program $program): float
    {
        return $package->courses->sum('price') + $program->tax_amount;
    }

    // Returns all 3 programs with their calculated price for the basket
    public function allPrograms(Package $package): Collection
    {
        return Program::all()->map(fn($program) => [
            'program' => $program,
            'price' => $this->calculate($package, $program),
        ]);
    }
}