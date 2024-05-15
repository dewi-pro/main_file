<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'voting_type',
        'multiple_answer_options',
        'require_participants_names',
        'voting_restrictions',
        'set_end_date',
        'set_end_date_time',
        'allow_comments',
        'hide_participants_from_each_other',
        'results_visibility',
        'image_answer_options',
        'image_require_participants_names',
        'image_voting_restrictions',
        'image_set_end_date',
        'image_set_end_date_time',
        'image_allow_comments',
        'image_hide_participants_from_each_other',
        'image_results_visibility',
        'meeting_answer_options',
        'meeting_allow_if_need_be_answer',
        'meeting_fixed_time_zone',
        'meetings_fixed_time_zone',
        'limit_selection_to_one_option_only',
        'meeting_set_end_date',
        'meeting_set_end_date_time',
        'meeting_allow_comments',
        'meeting_hide_participants_from_each_other'
    ];

    public function getPollArray()
    {
        return json_decode($this->multiple_answer_options);
    }

    public function getMeetingArray()
    {
        return json_decode($this->meeting_answer_options);
    }
    public function getPollImage()
    {
        return json_decode($this->image_answer_options);
    }

    public function commmant()
    {
        return $this->hasMany(Comments::class, 'poll_id', 'id');
    }
}
