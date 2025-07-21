<?php

namespace Database\Factories;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobVacancy>
 */
class JobVacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobVacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        $slug = Str::slug($title) . '-' . Str::random(5);
        
        $departments = [
            'Engineering', 'Design', 'Marketing', 'Sales', 
            'Customer Support', 'Finance', 'HR', 'Product',
            'Operations', 'Research and Development'
        ];
        
        $locations = [
            'Yogyakarta', 'Jakarta', 'Bandung', 'Surabaya', 'Remote'
        ];
        
        $employmentTypes = [
            'full-time', 'part-time', 'contract', 'internship'
        ];

        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => $this->faker->paragraphs(2, true),
            'responsibilities' => $this->faker->paragraphs(2, true),
            'location' => $this->faker->randomElement($locations),
            'employment_type' => $this->faker->randomElement($employmentTypes),
            'salary_range' => 'Rp ' . number_format($this->faker->numberBetween(5000000, 20000000), 0, ',', '.') . ' - Rp ' . number_format($this->faker->numberBetween(7000000, 25000000), 0, ',', '.'),
            'department' => $this->faker->randomElement($departments),
            'status' => $this->faker->randomElement(['active', 'closed']),
            'quota' => $this->faker->numberBetween(1, 5),
            'start_date' => now(),
            'end_date' => now()->addDays($this->faker->numberBetween(30, 90)),
            'created_by' => User::factory()->hrd(),
        ];
    }

    /**
     * Configure the model factory for active vacancies.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
            ];
        });
    }

    /**
     * Configure the model factory for closed vacancies.
     *
     * @return static
     */
    public function closed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'closed',
            ];
        });
    }
}