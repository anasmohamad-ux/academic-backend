<?php
namespace App\Services;

use App\Models\Enrollment;
use App\Models\Program;
use App\Models\User;

class EnrollmentService
{

    public function __construct(
        private PackageService $packageService,
        private PricingService $pricingService,
    ) {
    }

    public function enroll(User $user, array $courseIds, Program $program): Enrollment
    {
        $package = $this->packageService->findOrCreate($courseIds);
        $price = $this->pricingService->calculate($package, $program);

        return Enrollment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'program_id' => $program->id,
            'paid_price' => $price,
        ]);
    }

    public function cancel(User $user, int $packageId): void
    {
        Enrollment::where('user_id', $user->id)
            ->where('package_id', $packageId)
            ->delete();
    }
}