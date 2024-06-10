<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time_in',
        'time_out',
        'task_information',
        'is_approved',
        'approved_at',
        'user_id'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'boolean'
    ];

    /**
     * Get user record associated with the post.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get total working hours.
     *
     * @return integer
     */
    public function workingHours()
    {
        return abs(Carbon::parse($this->attributes['time_out'])->diffInMinutes(Carbon::parse($this->attributes['time_in'])) / 60);
    }

    /**
     * Set approval status.
     *
     * @return void
     */
    public function setApprovalStatus(bool $status)
    {
        $this->attributes['is_approved'] = $status;
        $this->attributes['approved_at'] = new \DateTime();
    }

    /**
     * Get the formatted time_in.
     *
     * @return string
     */
    public function getFormattedTimeInAttribute()
    {
        return Carbon::parse($this->attributes['time_in'])->format('g:i A');
    }

    /**
     * Get the formatted time_out.
     *
     * @return string
     */
    public function getFormattedTimeOutAttribute()
    {
        return Carbon::parse($this->attributes['time_out'])->format('g:i A');
    }
}
