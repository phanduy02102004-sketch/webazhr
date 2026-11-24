<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }

    public function latestApplication()
    {
        return $this->hasOne(Application::class, 'candidate_id')->latestOfMany();
    }

    public function graduations()
    {
        return $this->hasMany(InternGraduation::class, 'candidate_id');
    }

    public function latestGraduation()
    {
        return $this->hasOne(InternGraduation::class, 'candidate_id')->latestOfMany();
    }

    public function isOffered()
    {
        return $this->applications()->where('status', 'offered')->exists();
    }
}
