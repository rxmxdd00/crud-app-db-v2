<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'studentId',
        'courseId',
        'enrollment_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentId');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId');
    }
}
