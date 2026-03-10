<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ProgramResource;
use App\Services\PackageService;
use App\Services\PricingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function __construct(
        private PackageService $packageService,
        private PricingService $pricingService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'course_ids' => ['required', 'array', 'min:3'],
            'course_ids.*' => ['exists:courses,id'],
        ]);

        $courseIds = $request->course_ids;
        $package = $this->packageService->findOrCreate($courseIds);
        $programs = $this->pricingService->allPrograms($package);

        return response()->json([
            'package' => [
                'id' => $package->id,
                'title' => $package->title,
                'courses' => CourseResource::collection($package->courses),
            ],
            'programs' => $programs->map(fn($p) => [
                'program' => new ProgramResource($p['program']),
                'price' => $p['price'],
            ]),
        ]);
    }
}