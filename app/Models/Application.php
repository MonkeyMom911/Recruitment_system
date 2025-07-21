<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_vacancy_id',
        'status',
        'cv_path',
        'cover_letter',
        'expected_salary',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function stages()
    {
        return $this->hasMany(ApplicationStage::class);
    }

    public function getCurrentStage()
    {
        return $this->stages()
            ->whereHas('selectionStage', function ($query) {
                $query->orderBy('sequence', 'desc');
            })
            ->first();
    }
}
