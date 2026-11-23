<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function position()
    {
        return $this->belongsTo(InternshipPosition::class, 'position_id');
    }

    public function testResult()
    {
        return $this->hasOne(CandidateTest::class, 'application_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'application_id');
    }

    public function assignedMentor()
    {
        return $this->belongsTo(Admin::class, 'assigned_mentor_id');
    }

    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class, 'application_id');
    }

    public function graduation()
    {
        return $this->hasOne(InternGraduation::class, 'application_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'applied' => ['label' => 'Mới nộp', 'class' => 'bg-blue-100 text-blue-800'],
            'screening' => ['label' => 'Duyệt CV', 'class' => 'bg-amber-100 text-amber-800'],
            'test_sent' => ['label' => 'Đã gửi Test', 'class' => 'bg-indigo-100 text-indigo-800'],
            'tested' => ['label' => 'Đã hoàn thành Test', 'class' => 'bg-purple-100 text-purple-800'],
            'interviewing' => ['label' => 'Phỏng vấn', 'class' => 'bg-orange-100 text-orange-800'],
            'offered' => ['label' => 'Nhận thực tập', 'class' => 'bg-emerald-100 text-emerald-800'],
            'rejected' => ['label' => 'Từ chối (Đã gửi mail)', 'class' => 'bg-rose-100 text-rose-800'],
        ];

        return $badges[$this->status] ?? ['label' => $this->status, 'class' => 'bg-gray-100 text-gray-800'];
    }
}
