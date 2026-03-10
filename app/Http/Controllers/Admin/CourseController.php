<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = Course::with('teacher')->paginate(20);
        return response()->json(CourseResource::collection($courses));
    }

    public function update(UpdateCourseRequest $request, Course $course): JsonResponse
    {
        $this->authorize('update', $course);
        $course->update($request->validated());
        return response()->json(new CourseResource($course));
    }

    public function destroy(Course $course): JsonResponse
    {
        $this->authorize('delete', $course);
        $course->delete();
        return response()->json(['message' => 'Course deleted.']);
    }
}