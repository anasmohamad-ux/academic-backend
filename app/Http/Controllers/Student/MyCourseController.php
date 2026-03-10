<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\JsonResponse;

class MyCourseController extends Controller
{
    public function index(): JsonResponse
    {
        $enrollments = auth()->user()->enrollments()->with([
            'package.courses.teacher',
            'program',
        ])->get();

        return response()->json(EnrollmentResource::collection($enrollments));
    }
}