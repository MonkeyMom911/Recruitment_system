<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationDocument>
 */
class ApplicationDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentTypes = [
            'certificate', 'portfolio', 'recommendation', 'id_card', 'other'
        ];
        
        $fileTypes = [
            'pdf', 'doc', 'docx', 'jpg', 'png'
        ];
        
        $documentType = $this->faker->randomElement($documentTypes);
        $fileType = $this->faker->randomElement($fileTypes);
        
        return [
            'application_id' => Application::factory(),
            'document_type' => $documentType,
            'file_path' => 'applications/documents/sample-' . $documentType . '.' . $fileType,
        ];
    }

    /**
     * Configure the model factory for certificate documents.
     *
     * @return static
     */
    public function certificate(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'document_type' => 'certificate',
                'file_path' => 'applications/documents/sample-certificate.pdf',
            ];
        });
    }

    /**
     * Configure the model factory for portfolio documents.
     *
     * @return static
     */
    public function portfolio(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'document_type' => 'portfolio',
                'file_path' => 'applications/documents/sample-portfolio.pdf',
            ];
        });
    }

    /**
     * Configure the model factory for recommendation documents.
     *
     * @return static
     */
    public function recommendation(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'document_type' => 'recommendation',
                'file_path' => 'applications/documents/sample-recommendation.pdf',
            ];
        });
    }

    /**
     * Configure the model factory for ID card documents.
     *
     * @return static
     */
    public function idCard(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'document_type' => 'id_card',
                'file_path' => 'applications/documents/sample-id_card.jpg',
            ];
        });
    }
}