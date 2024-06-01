<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use HasFactory, SoftDeletes;

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
    protected $casts = [];

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
        return $this->time_out - $this->time_in;
    }

    /**
     * Set approval status.
     *
     * @return void
     */
    public function setApprovalStatus(bool $status)
    {
        $this->attributes['is_approved'] = $status;
    }
}
