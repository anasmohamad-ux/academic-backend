<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = auth()->user()->courses()->withCount('packages')->get();
        return response()->json(CourseResource::collection($courses));
    }

    public function store(StoreCourseRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $course = auth()->user()->courses()->create($data);
        return response()->json(new CourseResource($course), 201);
    }
}