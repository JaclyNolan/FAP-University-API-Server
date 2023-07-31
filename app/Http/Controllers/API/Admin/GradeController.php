<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\ClassEnrollment;
use App\Models\ClassCourse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    private $grade;
    public function __construct()
    {
        $this->grade = new Grade;
    }

    public function index(Request $request)
    {
        try {
            $query = Grade::select(
                $this->grade->getTable() . '.grade_id AS id',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                $this->grade->getTable() . '.status',
                $this->grade->getTable() . '.score'
            )
                ->join((new ClassEnrollment)->getTable(), $this->grade->getTable() . '.class_enrollment_id', '=', (new ClassEnrollment)->getTable() . '.class_enrollment_id')
                ->join((new Student)->getTable(), (new ClassEnrollment)->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new ClassCourse)->getTable(), (new ClassEnrollment)->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->orderBy($this->grade->getTable() . '.grade_id');

                if ($request->has('class')) {
                    $class = $request->input('class');
                    $query->where((new ClassModel)->getTable() . '.class_id', $class);
                }
                
                if ($request->has('course')) {
                    $course = $request->input('course');
                    $query->where((new Course)->getTable() . '.course_id', $course);
                }
                
                if ($request->has('keyword')) {
                    $keyword = $request->input('keyword');
                    $query->where(function ($q) use ($keyword) {
                        $q->where(function ($innerQuery) use ($keyword) {
                            $innerQuery->where((new Student)->getTable() . '.full_name', 'LIKE', "%$keyword%")
                            ->orWhere((new Student)->getTable() . '.student_id', 'LIKE', "$keyword")
                                ->orWhere($this->grade->getTable() . '.grade_id', 'LIKE', "$keyword");

                        });
                    });
                }

            $grades = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $grades->currentPage() > $grades->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($grades->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'grades' => [],
                    'total_pages' => $grades->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'grades' => $grades->items(),
                'total_pages' => $grades->lastPage(),
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
            $grade = Grade::select(
                $this->grade->getTable() . '.grade_id AS id',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                $this->grade->getTable() . '.status',
                $this->grade->getTable() . '.score'
            )
                ->join((new ClassEnrollment)->getTable(), $this->grade->getTable() . '.class_enrollment_id', '=', (new ClassEnrollment)->getTable() . '.class_enrollment_id')
                ->join((new Student)->getTable(), (new ClassEnrollment)->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new ClassCourse)->getTable(), (new ClassEnrollment)->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->where($this->grade->getTable() . '.grade_id', $id)
                ->first();

            if (!$grade) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Grade not found',
                    'error' => 'The requested grade does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'grade' => $grade,
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
            $grade = $this->grade::find($id);

            if (!$grade) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Grade not found',
                ], 404);
            }

           //$grade->class_enrollment_id = $request->input('class_enrollment_id');
            $grade->score = $request->input('score');
            $grade->status = $request->input('status');

            $grade->updated_at = date('Y-m-d H:i:s');
            $grade->update();

            return response()->json([
                'status' => 200,
                'message' => 'Grade Update Successfully!',
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
