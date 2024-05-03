<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public $fillable = [
        'firstName',
        'lastName',
        'DOB',
        'address',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'studentId');
    }
}
