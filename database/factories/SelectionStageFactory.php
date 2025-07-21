<?php

namespace Database\Factories;

use App\Models\JobVacancy;
use App\Models\SelectionStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SelectionStage>
 */
class SelectionStageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SelectionStage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stages = [
            'Document Screening' => 'Review of application documents including CV and cover letter',
            'Technical Test' => 'Assessment of technical skills relevant to the position',
            'Interview' => 'Interview with the hiring team to assess fit for the role',
            'Assignment' => 'Practical assignment to evaluate skills and problem-solving abilities',
            'Final Interview' => 'Final interview with senior management'
        ];
        
        $stageName = $this->faker->randomElement(array_keys($stages));
        
        return [
            'job_vacancy_id' => JobVacancy::factory(),
            'name' => $stageName,
            'description' => $stages[$stageName],
            'sequence' => $this->faker->numberBetween(1, 5),
        ];
    }

    /**
     * Create standard set of selection stages (Document Screening, Technical Test, Interview)
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function standardStages($jobVacancyId = null)
    {
        // This method is for use in seeders, not directly by the factory
        $jobVacancyId = $jobVacancyId ?? JobVacancy::factory()->create()->id;
        
        SelectionStage::create([
            'job_vacancy_id' => $jobVacancyId,
            'name' => 'Document Screening',
            'description' => 'Review of application documents including CV and cover letter',
            'sequence' => 1,
        ]);
        
        SelectionStage::create([
            'job_vacancy_id' => $jobVacancyId,
            'name' => 'Technical Test',
            'description' => 'Assessment of technical skills relevant to the position',
            'sequence' => 2,
        ]);
        
        SelectionStage::create([
            'job_vacancy_id' => $jobVacancyId,
            'name' => 'Interview',
            'description' => 'Interview with the hiring team to assess fit for the role',
            'sequence' => 3,
        ]);
        
        return $this;
    }

    /**
     * Configure the model factory for document screening stage.
     *
     * @return static
     */
    public function documentScreening(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Document Screening',
                'description' => 'Review of application documents including CV and cover letter',
                'sequence' => 1,
            ];
        });
    }

    /**
     * Configure the model factory for technical test stage.
     *
     * @return static
     */
    public function technicalTest(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Technical Test',
                'description' => 'Assessment of technical skills relevant to the position',
                'sequence' => 2,
            ];
        });
    }

    /**
     * Configure the model factory for interview stage.
     *
     * @return static
     */
    public function interview(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Interview',
                'description' => 'Interview with the hiring team to assess fit for the role',
                'sequence' => 3,
            ];
        });
    }
}