<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use App\Models\Major;
use App\Models\Course;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    private $enrollment;
    public function __construct()
    {
        $this->enrollment = new Enrollment;
    }
    public function index(Request $request)
    {
        try {
            $query = Enrollment::select(
                $this->enrollment->getTable() . '.enrollment_id AS id',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new User)->getTable() . '.email',
                (new Major)->getTable() . '.major_name',
                (new Course)->getTable() . '.course_name',
                (new Student)->getTable() . '.gpa',
                $this->enrollment->getTable() . '.status'
            )
                ->join((new Student)->getTable(), $this->enrollment->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new User)->getTable(), (new Student)->getTable() . '.student_id', '=', (new User)->getTable() . '.student_id')
                ->join((new Major)->getTable(), (new Student)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->join((new Course)->getTable(), $this->enrollment->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->orderBy($this->enrollment->getTable() . '.enrollment_id');

            if ($request->has('major')) {
                $major = $request->input('major');
                $query->where((new Major)->getTable() . '.major_id', $major);
            }

            if ($request->has('course')) {
                $course = $request->input('course');
                $query->where((new Course)->getTable() . '.course_id', $course);
            }

            if ($request->has('status')) {
                $status = $request->input('status');
                $query->where($this->enrollment->getTable() . '.status', $status);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where(function ($innerQuery) use ($keyword) {
                        $innerQuery->where((new Student)->getTable() . '.student_id', 'LIKE', "$keyword")
                            ->orWhere((new Student)->getTable() . '.full_name', 'LIKE', "%$keyword%")
                            ->orWhere((new User)->getTable() . '.email', 'LIKE', "%$keyword%")
                            ->orWhere($this->enrollment->getTable() . '.enrollment_id', 'LIKE', "$keyword");
                    });
                });
            }

            $enrollments = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $enrollments->currentPage() > $enrollments->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($enrollments->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'enrollments' => [],
                    'total_pages' => $enrollments->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'enrollments' => $enrollments->items(),
                'total_pages' => $enrollments->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to query the database',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $enrollment = Enrollment::select(
                $this->enrollment->getTable() . '.enrollment_id AS id',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new User)->getTable() . '.email',
                (new Major)->getTable() . '.major_name',
                (new Course)->getTable() . '.course_name',
                $this->enrollment->getTable() . '.status'
            )
                ->join((new Student)->getTable(), $this->enrollment->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new User)->getTable(), (new Student)->getTable() . '.student_id', '=', (new User)->getTable() . '.student_id')
                ->join((new Major)->getTable(), (new Student)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->join((new Course)->getTable(), $this->enrollment->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->where($this->enrollment->getTable() . '.enrollment_id', $id)
                ->first();

            if (!$enrollment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Enrollment not found',
                    'error' => 'The requested enrollment does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'enrollment' => $enrollment,
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
        try {
            $enrollment = $this->enrollment::find($id);

            if (!$enrollment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Enrollment not found',
                ], 404);
            }

            $enrollment->status = $request->input('status');

            $enrollment->updated_at = date('Y-m-d H:i:s');
            $enrollment->update();

            return response()->json([
                'status' => 200,
                'message' => 'Enrollment Update Successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
