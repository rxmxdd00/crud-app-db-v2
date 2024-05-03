<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'studentId' => $this->studentId,
            'courseId' => $this->courseId,
            'firstName' =>$this->firstName,
            'lastName' => $this->lastName,
            'address' => $this->address,
            'DOB' => $this->DOB,
            'courseName' => $this->courseName,
            'departmentId' => $this->departmentId,
            'enrollment_date' => $this->enrollment_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
