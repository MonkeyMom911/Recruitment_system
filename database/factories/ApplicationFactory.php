<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = [
            'applied', 'screening', 'interview', 'test', 'hired', 'rejected'
        ];

        return [
            'user_id' => User::factory()->applicant(),
            'job_vacancy_id' => JobVacancy::factory(),
            'status' => $this->faker->randomElement($statuses),
            'cv_path' => 'applications/cv/sample-cv.pdf',
            'cover_letter' => $this->faker->paragraphs(3, true),
            'expected_salary' => $this->faker->numberBetween(5000000, 20000000),
            'notes' => $this->faker->optional(0.7)->paragraphs(1, true),
        ];
    }

    /**
     * Configure the model factory for applications with 'applied' status.
     *
     * @return static
     */
    public function applied(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'applied',
            ];
        });
    }

    /**
     * Configure the model factory for applications with 'screening' status.
     *
     * @return static
     */
    public function screening(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'screening',
            ];
        });
    }

    /**
     * Configure the model factory for applications with 'interview' status.
     *
     * @return static
     */
    public function interview(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'interview',
            ];
        });
    }

    /**
     * Configure the model factory for applications with 'test' status.
     *
     * @return static
     */
    public function test(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'test',
            ];
        });
    }

    /**
     * Configure the model factory for applications with 'hired' status.
     *
     * @return static
     */
    public function hired(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'hired',
            ];
        });
    }

    /**
     * Configure the model factory for applications with 'rejected' status.
     *
     * @return static
     */
    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
            ];
        });
    }
}