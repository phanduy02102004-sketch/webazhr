<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipPosition extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(Application::class, 'position_id');
    }

    public function questions()
    {
        return $this->hasMany(TestQuestion::class, 'position_id');
    }
}
