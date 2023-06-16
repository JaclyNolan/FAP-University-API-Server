<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index(){
        $students = Student::select('students.student_id AS id', 'students.image', 'students.date_of_birth AS Dob', 'users.email', 'students.phone_number AS phone', 'students.address')
        ->join('users', 'students.student_id', '=', 'users.student_id')
        ->get();
        
        return response()->json([
            'status' => 200,
            'students' => $students,
        ]);
    }
    
}
