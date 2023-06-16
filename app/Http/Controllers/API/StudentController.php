<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $student = new Student;

        $students = Student::select(
            $student->getTable() . '.student_id AS id',
            $student->getTable() . '.full_name',
            $student->getTable() . '.image',
            $student->getTable() . '.gender',
            $student->getTable() . '.academic_year',
            $student->getTable() . '.date_of_birth AS Dob',
            (new User)->getTable() . '.email',
            $student->getTable() . '.phone_number AS phone',
            $student->getTable() . '.address',
            (new Major)->getTable() . '.major_name'
        )
            ->leftJoin((new User)->getTable(), $student->getTable() . '.student_id', '=', (new User)->getTable() . '.student_id')
            ->join((new Major)->getTable(), $student->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
            ->orderBy($student->getTable() . '.student_id')
            ->get();

        return response()->json([
            'status' => 200,
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $student = new Student;
        $student->student_id = $request->input('student_id');
        $student->full_name = $request->input('full_name');
        $student->gender = $request->input('gender');
        $student->major_id = $request->input('major_id');
        $student->address = $request->input('address');
        $student->phone_number = $request->input('phone_number');
        $student->status = $request->input('status');
        $student->image = $request->input('image');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->academic_year = $request->input('academic_year');

        $student->created_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
        $student->save();

        return response()->json([
            'status' => 200,
            'message' => 'Student added Successfully!',
        ]);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        return response()->json([
            'status' => 200,
            'student' => $student,
        ]);
    }
}
