<?php
namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->user()->hasRole('student');
    }

    public function rules(): array
    {
        return [
            'course_ids' => ['required', 'array', 'min:3'],
            'course_ids.*' => ['exists:courses,id'],
            'program_id' => ['required', 'exists:programs,id'],
        ];
    }
}