<?php
namespace App\Exports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobVacanciesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = JobVacancy::with('creator')->withCount('applications');

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['department'])) {
            $query->where('department', $this->filters['department']);
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
            'Title',
            'Department',
            'Location',
            'Employment Type',
            'Quota',
            'Applications',
            'Status',
            'Start Date',
            'End Date',
            'Created By',
            'Created At',
        ];
    }

    public function map($jobVacancy): array
    {
        return [
            $jobVacancy->id,
            $jobVacancy->title,
            $jobVacancy->department,
            $jobVacancy->location,
            ucfirst($jobVacancy->employment_type),
            $jobVacancy->quota,
            $jobVacancy->applications_count,
            ucfirst($jobVacancy->status),
            $jobVacancy->start_date->format('Y-m-d'),
            $jobVacancy->end_date->format('Y-m-d'),
            $jobVacancy->creator->name,
            $jobVacancy->created_at->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}