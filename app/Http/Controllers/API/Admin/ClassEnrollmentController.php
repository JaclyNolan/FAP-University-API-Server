<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassEnrollment;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Major;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\ClassCourse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ClassEnrollmentController extends Controller
{
    private $classEnrollment;
    public function __construct()
    {
        $this->classEnrollment = new ClassEnrollment;
    }

    public function buildSingleClassEnrollment(Builder $query, $id)
    {
        $classEnrollment = $query->where('class_enrollment_id', $id);
        return $classEnrollment;
    }
    public function buildMultipleClassEnrollment(Builder $query, Request $request)
    {
        $class_id = $request->input('class_id');
        $course_id = $request->input('course_id');
        $student_id = $request->input('student_id');
        $instructor_id = $request->input('instructor_id');
        $keyword = $request->input('keyword');

        if ($class_id) {
            $query->whereHas('classCourse.class', function ($q) use ($class_id) {
                $q->where('class_id', $class_id);
            });
        }
        if ($course_id) {
            $query->whereHas('classCourse.course', function ($q) use ($course_id) {
                $q->where('course_id', $course_id);
            });
        }
        if ($student_id) {
            $query->whereHas('student', function ($q) use ($student_id) {
                $q->where('student_id', $student_id);
            });
        }
        if ($instructor_id) {
            $query->whereHas('instructor', function ($q) use ($instructor_id) {
                $q->where('instructor_id', $instructor_id);
            });
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('class_enrollment_id', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('classCourse.course', function ($q) use ($keyword) {
                        $q->where('course_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('classCourse.class', function ($q) use ($keyword) {
                        $q->where('class_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('classCourse.instructor', function ($q) use ($keyword) {
                        $q->where('full_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('student', function ($q) use ($keyword) {
                        $q->where('full_name', 'LIKE', "%{$keyword}%");
                    });
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $query = ClassEnrollment::select(
                $this->classEnrollment->getTable() . '.class_enrollment_id AS id',
                (new ClassCourse)->getTable() . '.class_course_id',
                (new Instructor)->getTable() . '.instructor_id',
                (new Instructor)->getTable() . '.full_name AS instructor_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new Student)->getTable() . '.image AS student_image',
                (new Student)->getTable() . '.gender AS student_gender',
                $this->classEnrollment->getTable() . '.created_at',
            )
                ->join((new ClassCourse)->getTable(), $this->classEnrollment->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new Instructor)->getTable(), (new ClassCourse)->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Major)->getTable(), (new ClassModel)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->join((new Student)->getTable(), $this->classEnrollment->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->whereNull($this->classEnrollment->getTable() . '.deleted_at')
                ->orderBy($this->classEnrollment->getTable() . '.class_enrollment_id');

            if ($user->role_id == 3) {
                $query->where((new Instructor)->getTable() . '.instructor_id', $user->instructor_id);
            }

            if ($request->has('student_id')) {
                $student = $request->input('student_id');
                $query->where((new Student)->getTable() . '.student_id', $student);
            }

            if ($request->has('major_id')) {
                $major = $request->input('major_id');
                $query->where((new Major)->getTable() . '.major_id', $major);
            }

            if ($request->has('course_id')) {
                $course = $request->input('course_id');
                $query->where((new Course)->getTable() . '.course_id', $course);
            }

            if ($request->has('class_id')) {
                $class = $request->input('class_id');
                $query->where((new ClassModel)->getTable() . '.class_id', $class);
            }

            if ($request->has('class_course_id')) {
                $classCourse = $request->input('class_course_id');
                $query->where((new ClassCourse)->getTable() . '.class_course_id', $classCourse);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where((new ClassEnrollment)->getTable() . '.class_enrollment_id', 'LIKE', "%$keyword%")
                        ->orWhere((new ClassModel)->getTable() . '.class_name', 'LIKE', "%$keyword%")
                        ->orWhere((new Student)->getTable() . '.student_id', 'LIKE', "$keyword")
                        ->orWhere((new Student)->getTable() . '.full_name', 'LIKE', "%$keyword%");
                });
            }

            $classEnrollments = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $classEnrollments->currentPage() > $classEnrollments->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($classEnrollments->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'classEnrollments' => [],
                    'total_pages' => $classEnrollments->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'classEnrollments' => $classEnrollments->items(),
                'total_pages' => $classEnrollments->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to query the database',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexForStudent(Request $request)
    {
        $user = $request->user();
        $query = ClassEnrollment::query();
        $query->where('student_id', $user->student_id);
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassEnrollment)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);
        $query->select($columnsToSelect);
        //Apply filter and search
        $query = $this->buildMultipleClassEnrollment($query, $request);
        $classEnrollments = $query->with([
            'classCourse:class_course_id,class_id,course_id,instructor_id',
            'classCourse.class:class_id,class_name',
            'classCourse.course:course_id,course_name',
            'classCourse.instructor:instructor_id,full_name',
        ])->get();

        return response()->json([
            'classEnrollments' => $classEnrollments,
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $this->classEnrollment->class_course_id = $request->input('class_course_id');
            $this->classEnrollment->student_id = $request->input('student_id');

            $this->classEnrollment->created_at = date('Y-m-d H:i:s');
            $this->classEnrollment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Class Enrollment added successfully!',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add class',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showForInstructor(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassEnrollment::query();
        $query->whereHas('classCourse', function ($q) use ($user) {
            $q->where('instructor_id', $user->instructor_id);
        });
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassEnrollment)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        return response()->json([
            'classEnrollment' => $this->buildSingleClassEnrollment($query, $id)->first(),
        ], 200);
    }


    public function edit($id)
    {
        try {
            $classEnrollment = ClassEnrollment::select(
                $this->classEnrollment->getTable() . '.class_enrollment_id AS id',
                (new ClassCourse)->getTable() . '.class_course_id',
                (new Instructor)->getTable() . '.instructor_id',
                (new Instructor)->getTable() . '.full_name AS instructor_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                $this->classEnrollment->getTable() . '.created_at',
                $this->classEnrollment->getTable() . '.updated_at',
            )
                ->join((new ClassCourse)->getTable(), $this->classEnrollment->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new Instructor)->getTable(), (new ClassCourse)->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Major)->getTable(), (new ClassModel)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->join((new Student)->getTable(), $this->classEnrollment->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->where($this->classEnrollment->getTable() . '.class_enrollment_id', $id)
                ->whereNull($this->classEnrollment->getTable() . '.deleted_at')
                ->first();

            if (!$classEnrollment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class Enrollment not found',
                    'error' => 'The requested class enrollment does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'classEnrollment' => $classEnrollment,
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
            $classEnrollment = $this->classEnrollment::find($id);

            // Kiểm tra xem khóa học có tồn tại không
            if (!$classEnrollment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class enrollment not found',
                ], 404);
            }

            $classEnrollment->class_course_id = $request->input('class_course_id');
            $classEnrollment->student_id = $request->input('student_id');

            $classEnrollment->updated_at = date('Y-m-d H:i:s');
            $classEnrollment->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Enrollment Update Successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $classEnrollment = $this->classEnrollment::find($id);

            if (!$classEnrollment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class enrollment not found',
                ], 404);
            }

            $classEnrollment->deleted_at = date('Y-m-d H:i:s');
            $classEnrollment->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Enrollment Delete Successfully!',
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
