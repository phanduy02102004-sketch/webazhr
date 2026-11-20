<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateTest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'answers_data' => 'array',
        'passed' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
