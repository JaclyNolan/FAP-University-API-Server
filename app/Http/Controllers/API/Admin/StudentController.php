<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $student;

    public function __construct()
    {
        $this->student = new Student;
    }
    public function index(Request $request)
    {
        try {
            $query = Student::select(
                $this->student->getTable() . '.student_id AS id',
                $this->student->getTable() . '.full_name',
                $this->student->getTable() . '.image',
                $this->student->getTable() . '.gender',
                $this->student->getTable() . '.academic_year',
                $this->student->getTable() . '.date_of_birth AS Dob',
                (new User)->getTable() . '.email',
                $this->student->getTable() . '.phone_number',
                $this->student->getTable() . '.address',
                (new Major)->getTable() . '.major_id',

                (new Major)->getTable() . '.major_name',
                $this->student->getTable() . '.status',
            )
                ->leftJoin((new User)->getTable(), $this->student->getTable() . '.student_id', '=', (new User)->getTable() . '.student_id')
                ->join((new Major)->getTable(), $this->student->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->student->getTable() . '.deleted_at')
                ->orderBy($this->student->getTable() . '.student_id');

            // Áp dụng bộ lọc nếu có
            if ($request->has('gender')) {
                $gender = $request->input('gender');
                $query->where($this->student->getTable() . '.gender', $gender);
            }

            if ($request->has('major')) {
                $major = $request->input('major');
                $query->where((new Major)->getTable() . '.major_id', $major);
            }

            if ($request->has('academic_year')) {
                $academicYear = $request->input('academic_year');
                $query->where($this->student->getTable() . '.academic_year', $academicYear);
            }

            if ($request->has('status')) {
                $status = $request->input('status');
                $query->where($this->student->getTable() . '.status', $status);
            }

            // Áp dụng tìm kiếm từ khóa
            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->student->getTable() . '.full_name', 'LIKE', "%$keyword%")
                        ->orWhere((new User)->getTable() . '.email', 'LIKE', "%$keyword%")
                        ->orWhere($this->student->getTable() . '.phone_number', 'LIKE', "%$keyword%")
                        ->orWhere($this->student->getTable() . '.student_id', 'LIKE', "$keyword");
                });
            }

            $students = $query->paginate(10); // Số bản ghi trên mỗi trang
            if ($students->currentPage() > $students->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid Page',
                    'error' => 'The requested page does not exist.',
                ], 400);
            }

            // Kiểm tra số lượng bản ghi trả về
            if ($students->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'students' => [],
                    'total_pages' => $students->lastPage(),
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'students' => $students->items(),
                'total_pages' => $students->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Database Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $this->student::beginTransaction();
        try {
            $this->student->student_id = $request->input('student_id');
            $this->student->full_name = $request->input('full_name');
            $this->student->gender = $request->input('gender');
            $this->student->major_id = $request->input('major_id');
            $this->student->address = $request->input('address');
            $this->student->phone_number = $request->input('phone_number');
            $this->student->status = $request->input('status');
            $this->student->image = $request->input('image');
            $this->student->date_of_birth = $request->input('date_of_birth');
            $this->student->academic_year = $request->input('academic_year');

            $this->student->created_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
            $this->student->save();
            $this->student::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Student added Successfully!',
            ]);
        } catch (\Exception $e) {
            $this->student::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $student = Student::select(
                $this->student->getTable() . '.student_id AS id',
                $this->student->getTable() . '.full_name',
                $this->student->getTable() . '.image',
                $this->student->getTable() . '.gender',
                $this->student->getTable() . '.academic_year',
                $this->student->getTable() . '.date_of_birth AS Dob',
                (new User)->getTable() . '.email',
                (new User)->getTable() . '.username',
                $this->student->getTable() . '.phone_number AS phone',
                $this->student->getTable() . '.address',
                $this->student->getTable() . '.gpa',
                $this->student->getTable() . '.status',
                (new Major)->getTable() . '.major_name'
            )
                ->leftJoin((new User)->getTable(),  $this->student->getTable() . '.student_id', '=', (new User)->getTable() . '.student_id')
                ->join((new Major)->getTable(),  $this->student->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->student->getTable() . '.deleted_at')
                ->where($this->student->getTable() . '.student_id', $id)
                ->first();
            if (!$student) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                    'error' => 'The requested student does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->student::beginTransaction();
        try {
            $student = $this->student::find($id);
            if (!$student) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                    'error' => 'The requested student does not exist.',
                ], 404);
            }
            $student->full_name = $request->input('full_name');
            $student->date_of_birth = $request->input('date_of_birth');
            $student->gender = $request->input('gender');
            $student->address = $request->input('address');
            $student->phone_number = $request->input('phone_number');
            $student->status = $request->input('status');
            $student->major_id = $request->input('major_id');
            $student->academic_year = $request->input('academic_year');
            $student->image = $request->input('image');
            $student->updated_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
            $student->update();
            $this->student::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Student Update Successfully!',
            ]);
        } catch (\Exception $e) {
            $this->student::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        $this->student::beginTransaction();
        try {
            $student = $this->student::find($id);
            if (!$student) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                    'error' => 'The requested student does not exist.',
                ], 404);
            }
            $student->deleted_at = date('Y-m-d H:i:s');
            $student->update();
            $this->student::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Student Delete Successfully!',
            ]);
        } catch (\Exception $e) {
            $this->student::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
