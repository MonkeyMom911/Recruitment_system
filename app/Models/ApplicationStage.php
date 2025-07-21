<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'selection_stage_id',
        'status',
        'score',
        'notes',
        'scheduled_date',
        'completed_date',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'completed_date' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function selectionStage()
    {
        return $this->belongsTo(SelectionStage::class);
    }
}
