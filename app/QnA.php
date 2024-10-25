<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class QnA extends Model
{
    protected $table = 'question_answer';

    protected $guarded = [];

    protected $casts = [
        'amount_up' => 'integer',
        'amount_down' => 'integer'
    ];

    public function getContactTime($date)
    {
        return Carbon::parse($date);
    }

    public function getContactTimeEnd($date)
    {
        return Carbon::parse($date);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function categoryRelation()
    {
        return $this->hasMany(QACategoryRelation::class, 'qa_id');
    }

    public function collectQa()
    {
        return $this->hasMany(CollectQA::class, 'qa_id');
    }

    public function attachments()
    {
        return $this->hasMany(QnaAttachment::class, 'qa_id');
    }

}
