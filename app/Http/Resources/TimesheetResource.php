<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out,
            'task_information' => $this->task_information,
            'is_approved' => $this->is_approved,
            'approved_at' => $this->approved_at,
        ];
    }
}
