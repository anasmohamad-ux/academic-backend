<?php
namespace Tests\Feature;

use App\Models\Course;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_student_can_enroll(): void
    {
        $student = User::factory()->create()->assignRole('student');
        $courses = Course::factory()->count(3)->create(['price' => 100]);
        $program = Program::factory()->create(['tax_amount' => 50]);
        $token = $student->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/student/enroll', [
                'course_ids' => $courses->pluck('id')->toArray(),
                'program_id' => $program->id,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'paid_price' => 350,
        ]);
    }

    public function test_student_cannot_enroll_with_less_than_3_courses(): void
    {
        $student = User::factory()->create()->assignRole('student');
        $courses = Course::factory()->count(2)->create();
        $program = Program::factory()->create();
        $token = $student->createToken('api-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/student/enroll', [
                'course_ids' => $courses->pluck('id')->toArray(),
                'program_id' => $program->id,
            ])
            ->assertStatus(422);
    }

    public function test_student_can_cancel_enrollment(): void
    {
        $student = User::factory()->create()->assignRole('student');
        $courses = Course::factory()->count(3)->create(['price' => 100]);
        $program = Program::factory()->create(['tax_amount' => 50]);
        $token = $student->createToken('api-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/student/enroll', [
                'course_ids' => $courses->pluck('id')->toArray(),
                'program_id' => $program->id,
            ]);

        $enrollment = $student->enrollments()->first();

        $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/student/enrollment/{$enrollment->package_id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('enrollments', ['user_id' => $student->id]);
    }
}