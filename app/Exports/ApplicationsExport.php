<?php
namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicationsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Application::with(['user', 'jobVacancy']);

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['job_vacancy_id'])) {
            $query->where('job_vacancy_id', $this->filters['job_vacancy_id']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('created_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Applicant Name',
            'Email',
            'Phone',
            'Job Position',
            'Department',
            'Status',
            'Expected Salary',
            'Applied Date',
            'Last Update',
        ];
    }

    public function map($application): array
    {
        return [
            $application->id,
            $application->user->name,
            $application->user->email,
            $application->user->phone_number,
            $application->jobVacancy->title,
            $application->jobVacancy->department,
            ucfirst($application->status),
            $application->expected_salary ? number_format($application->expected_salary, 2) : 'N/A',
            $application->created_at->format('Y-m-d'),
            $application->updated_at->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
