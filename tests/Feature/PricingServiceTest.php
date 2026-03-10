<?php
namespace Tests\Unit;

use App\Models\Course;
use App\Models\Package;
use App\Models\Program;
use App\Services\PricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_price_equals_course_sum_plus_tax(): void
    {
        $service = new PricingService();
        $package = Package::factory()->create();
        $courses = Course::factory()->count(3)->create(['price' => 200]);
        $package->courses()->attach($courses->pluck('id'));
        $package->load('courses');
        $program = Program::factory()->create(['tax_amount' => 100]);

        $this->assertEquals(700, $service->calculate($package, $program));
    }
}