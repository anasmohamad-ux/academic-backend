<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\EnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Package;
use App\Models\Program;
use App\Services\EnrollmentService;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    public function __construct(private EnrollmentService $service)
    {
    }

    public function store(EnrollmentRequest $request): JsonResponse
    {
        $enrollment = $this->service->enroll(
            auth()->user(),
            $request->validated('course_ids'),
            Program::findOrFail($request->validated('program_id')),
        );

        return response()->json(
            new EnrollmentResource($enrollment->load('package.courses', 'program')),
            201
        );
    }

    public function destroy(Package $package): JsonResponse
    {
        $this->service->cancel(auth()->user(), $package->id);
        return response()->json(['message' => 'Enrollment cancelled successfully.']);
    }
}