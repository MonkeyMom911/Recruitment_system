<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationStage;
use App\Models\SelectionStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationStage>
 */
class ApplicationStageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationStage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = [
            'pending', 'in_progress', 'passed', 'failed'
        ];
        
        $hasScore = $this->faker->boolean(70);
        $status = $this->faker->randomElement($statuses);
        
        $scheduledDate = null;
        $completedDate = null;
        
        // If status is in_progress, set scheduled date
        if ($status === 'in_progress') {
            $scheduledDate = now()->addDays($this->faker->numberBetween(1, 14));
        }
        
        // If status is passed or failed, set completed date
        if ($status === 'passed' || $status === 'failed') {
            $scheduledDate = now()->subDays($this->faker->numberBetween(5, 20));
            $completedDate = now()->subDays($this->faker->numberBetween(1, 4));
        }

        return [
            'application_id' => Application::factory(),
            'selection_stage_id' => SelectionStage::factory(),
            'status' => $status,
            'score' => $hasScore ? $this->faker->numberBetween(60, 100) : null,
            'notes' => $this->faker->optional(0.7)->sentence(),
            'scheduled_date' => $scheduledDate,
            'completed_date' => $completedDate,
        ];
    }

    /**
     * Configure the model factory for pending stages.
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'scheduled_date' => null,
                'completed_date' => null,
            ];
        });
    }

    /**
     * Configure the model factory for in progress stages.
     *
     * @return static
     */
    public function inProgress(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'in_progress',
                'scheduled_date' => now()->addDays($this->faker->numberBetween(1, 14)),
                'completed_date' => null,
            ];
        });
    }

    /**
     * Configure the model factory for passed stages.
     *
     * @return static
     */
    public function passed(): static
    {
        return $this->state(function (array $attributes) {
            $scheduledDate = now()->subDays($this->faker->numberBetween(5, 20));
            return [
                'status' => 'passed',
                'score' => $this->faker->numberBetween(75, 100),
                'scheduled_date' => $scheduledDate,
                'completed_date' => $scheduledDate->copy()->addDays($this->faker->numberBetween(1, 5)),
            ];
        });
    }

    /**
     * Configure the model factory for failed stages.
     *
     * @return static
     */
    public function failed(): static
    {
        return $this->state(function (array $attributes) {
            $scheduledDate = now()->subDays($this->faker->numberBetween(5, 20));
            return [
                'status' => 'failed',
                'score' => $this->faker->numberBetween(30, 65),
                'scheduled_date' => $scheduledDate,
                'completed_date' => $scheduledDate->copy()->addDays($this->faker->numberBetween(1, 5)),
            ];
        });
    }
}