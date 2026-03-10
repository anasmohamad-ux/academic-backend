<?php
namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $popularCourses = Course::popular()->with('teacher')->get();
        return response()->json(CourseResource::collection($popularCourses));
    }
}