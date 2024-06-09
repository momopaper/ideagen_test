<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'ic' => $this->ic,
            'epf_no' => $this->epf_no,
            'socso_no' => $this->socso_no,
            'employee_no' => $this->employee_no,
        ];
    }
}
