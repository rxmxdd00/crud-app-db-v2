<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'courseName' => $this->courseName,
            'departmentId' => $this->departmentId,
            'departmentName' => $this->departmentName,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
