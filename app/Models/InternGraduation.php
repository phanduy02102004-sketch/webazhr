<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternGraduation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'survey_1_completed' => 'boolean',
        'survey_2_completed' => 'boolean',
        'report_draft_submitted' => 'boolean',
        'report_final_submitted' => 'boolean',
        'hard_copy_submitted' => 'boolean',
        'appointment_booked' => 'boolean',
        'referral_completed' => 'boolean',
        'word_report_submitted' => 'boolean',
        'video_submitted' => 'boolean',
        'review_map1' => 'boolean',
        'review_map2' => 'boolean',
        'review_page_homes' => 'boolean',
        'review_page_media' => 'boolean',
        'review_page_hr' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    /**
     * Tính toán % tiến độ hoàn thành các tiêu chí
     */
    public function getProgressPercentAttribute()
    {
        $items = [
            $this->survey_1_completed && $this->survey_2_completed,
            !empty($this->survey_proof_link),
            $this->report_draft_submitted,
            $this->report_final_submitted,
            $this->appointment_booked,
            $this->referral_completed,
            $this->word_report_submitted,
            $this->video_submitted,
            ($this->review_map1 && $this->review_map2 && $this->review_page_homes && $this->review_page_media && $this->review_page_hr),
            !empty($this->review_proof_link),
        ];

        $completed = count(array_filter($items));
        return (int) round(($completed / count($items)) * 100);
    }

    /**
     * Nhãn badge trạng thái
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'in_progress' => ['label' => 'Đang thực hiện', 'class' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'pending_review' => ['label' => 'Chờ BĐH duyệt', 'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'approved' => ['label' => 'Đạt Chuẩn Đầu Ra (Đã cấp mộc)', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'needs_update' => ['label' => 'Cần bổ sung hồ sơ', 'class' => 'bg-rose-100 text-rose-800 border-rose-300'],
        ];

        return $badges[$this->status] ?? ['label' => $this->status, 'class' => 'bg-gray-100 text-gray-800 border-gray-300'];
    }
}
