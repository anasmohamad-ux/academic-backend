<?php
namespace App\Services;

use App\Models\Package;

class PackageService
{

    // Same courses always produce the same package — no duplicates
    public function findOrCreate(array $courseIds): Package
    {
        sort($courseIds);
        $hash = md5(implode(',', $courseIds));

        $package = Package::firstOrCreate(
            ['hash' => $hash],
            ['title' => 'Package ' . strtoupper(substr($hash, 0, 6))]
        );

        if ($package->wasRecentlyCreated) {
            $package->courses()->attach($courseIds);
        }

        return $package;
    }
}