<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectionStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_vacancy_id',
        'name',
        'description',
        'sequence',
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function applicationStages()
    {
        return $this->hasMany(ApplicationStage::class);
    }
}
