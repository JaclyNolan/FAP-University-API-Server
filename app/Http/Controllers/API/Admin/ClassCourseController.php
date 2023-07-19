<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClassCourse;
use App\Models\ClassEnrollment;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\ClassModel;
use App\Models\Major;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

class ClassCourseController extends Controller
{
    private $classCourse;
    public function __construct()
    {
        $this->classCourse = new ClassCourse;
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $query = ClassCourse::select(
                $this->classCourse->getTable() . '.class_course_id AS id',
                (new Instructor)->getTable() . '.instructor_id',
                (new Instructor)->getTable() . '.full_name AS instructor_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name'
            )
                ->join((new Instructor)->getTable(), $this->classCourse->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
                ->join((new Course)->getTable(), $this->classCourse->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new ClassModel)->getTable(), $this->classCourse->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Major)->getTable(), (new ClassModel)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->classCourse->getTable() . '.deleted_at')
                ->orderBy($this->classCourse->getTable() . '.class_course_id');

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

            if ($request->has('instructor_id')) {
                $instructor = $request->input('instructor_id');
                $query->where($this->classCourse->getTable() . '.instructor_id', $instructor);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->classCourse->getTable() . '.class_course_id', 'LIKE', "%$keyword%")
                        ->orWhere((new Instructor)->getTable() . '.full_name', 'LIKE', "%$keyword%")
                        ->orWhere((new Course)->getTable() . '.course_name', 'LIKE', "%$keyword%")
                        ->orWhere((new ClassModel)->getTable() . '.class_name', 'LIKE', "%$keyword%")
                        ->orWhere((new Major)->getTable() . '.major_name', 'LIKE', "%$keyword%");
                });
            }

            $classCourses = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $classCourses->currentPage() > $classCourses->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($classCourses->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'classCourses' => [],
                    'total_pages' => $classCourses->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'classCourses' => $classCourses->items(),
                'total_pages' => $classCourses->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to query the database',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->classCourse->class_id = $request->input('class_id');
            $this->classCourse->course_id = $request->input('course_id');
            $this->classCourse->instructor_id = $request->input('instructor_id');
            $this->classCourse->created_at = date('Y-m-d H:i:s');
            $this->classCourse->save();
            $this->classCourse::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Class course added successfully!',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add class course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function buildMultipleClassCourse(Builder $query, Request $request)
    {
        $class_id = $request->input('class_id');
        $course_id = $request->input('course_id');
        $major_id = $request->input('major_id');
        $instructor_id = $request->input('instructor_id');
        $keyword = $request->input('keyword');

        if ($class_id) {
            $query->whereHas('class', function ($q) use ($class_id) {
                $q->where('class_id', $class_id);
            });
        }
        if ($course_id) {
            $query->whereHas('course', function ($q) use ($course_id) {
                $q->where('course_id', $course_id);
            });
        }
        if ($major_id) {
            $query->whereHas('class.major', function ($q) use ($major_id) {
                $q->where('major_id', $major_id);
            });
        }
        if ($instructor_id) {
            $query->whereHas('instructor', function ($q) use ($instructor_id) {
                $q->where('instructor_id', $instructor_id);
            });
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('class_course_id', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('course', function ($q) use ($keyword) {
                        $q->where('course_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('class', function ($q) use ($keyword) {
                        $q->where('class_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('class.major', function ($q) use ($keyword) {
                        $q->where('major_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('instructor', function ($q) use ($keyword) {
                        $q->where('full_name', 'LIKE', "%{$keyword}%");
                    });
            });
        }
        return $query;
    }

    private function buildSingleClassCourse(Builder $query, $id)
    {
        $query->where('class_course_id', $id);
        return $query;
    }

    public function indexForInstructor(Request $request)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        $query->where('instructor_id', $user->instructor_id);
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);
        $query->select($columnsToSelect);
        //Apply filter and search
        $query = $this->buildMultipleClassCourse($query, $request);
        $classCourses = $query->with([
            'class:class_id,major_id,class_name',
            'course:course_id,course_name',
            'class.major:major_id,major_name',
        ])->get();

        return response()->json([
            'classCourses' => $classCourses,
        ], 200);
    }

    public function indexForStudent(Request $request)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        $query->whereHas('classEnrollments', function ($q) use ($user){
            $q->where('student_id', $user->student_id);
        });
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);
        $query->select($columnsToSelect);
        //Apply filter and search
        $query = $this->buildMultipleClassCourse($query, $request);
        $classCourses = $query->with([
            'class:class_id,major_id,class_name',
            'course:course_id,course_name',
            'instructor:instructor_id,full_name',
        ])->get();

        return response()->json([
            'classCourses' => $classCourses,
        ], 200);
    }

    public function showForInstructor(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        $query->where('class_course_id', $id);
        $query->where('instructor_id', $user->instructor_id);
        $query = $this->buildSingleClassCourse($query, $id);

        $classCourse = $query->with([
            'class:class_id,class_name',
            'course:course_id,course_name',
        ])->first();
        return response()->json([
            'classCourse' => $classCourse,
        ], 200);
    }

    public function showForStudent(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        $query->where('class_course_id', $id);
        $query->whereHas('classEnrollments', function ($q) use ($user){
            $q->where('student_id', $user->student_id);
        });
        $query = $this->buildSingleClassCourse($query, $id);

        $classCourse = $query->with([
            'class:class_id,class_name',
            'course:course_id,course_name',
            'instructor:instructor_id,full_name',
        ])->first();
        return response()->json([
            'classCourse' => $classCourse,
        ], 200);
    }

    public function showStudentsForInstructor(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        $query = $this->buildSingleClassCourse($query, $id);
        $query->where('instructor_id', $user->instructor_id);
        $classCourse = $query->with(
            'classEnrollments:class_course_id,class_enrollment_id,student_id',
            'classEnrollments.student:student_id,image,full_name,gender',
            'classEnrollments.student.user:student_id,email',
        )->first();

        return response()->json([
            'classCourse' => $classCourse,
        ], 200);
    }

    public function showStudentsForStudent(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        $query = $this->buildSingleClassCourse($query, $id);
        $query->whereHas('classEnrollments', function ($q) use ($user){
            $q->where('student_id', $user->student_id);
        });
        $classCourse = $query->with(
            'classEnrollments:class_course_id,class_enrollment_id,student_id',
            'classEnrollments.student:student_id,image,full_name,gender,date_of_birth',
        )->first();

        return response()->json([
            'classCourse' => $classCourse,
        ], 200);
    }

    public function showClassSchedulesForInstructor(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        $query = $this->buildSingleClassCourse($query, $id);
        $query->where('instructor_id', $user->instructor_id);
        $classCourse = $query->with([
            'classSchedules' => function ($query) {
                $query->select('class_schedule_id', 'class_course_id', 'day', 'slot', 'room', 'status', 'submit_time')
                    ->orderBy('day', 'desc');
            }
        ])->first();

        return response()->json([
            'classCourse' => $classCourse,
        ], 200);
    }

    public function showClassSchedulesForStudent(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassCourse::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassCourse)->getTable());

        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);

        // Select the desired columns
        $query->select($columnsToSelect);
        $query = $this->buildSingleClassCourse($query, $id);
        $query->whereHas('classEnrollments', function ($q) use ($user){
            $q->where('student_id', $user->student_id);
        });
        $classCourse = $query->with([
            'classSchedules' => function ($query) {
                $query->select('class_schedule_id', 'class_course_id', 'day', 'slot', 'room', 'status', 'submit_time')
                    ->orderBy('day', 'desc');
            },
            'classSchedules.attendances' => function ($query) use ($user) {
                $query->select('attendance_id','class_schedule_id','class_enrollment_id','attendance_status','attendance_time')
                ->whereHas('classEnrollment', function ($q) use ($user) {
                    $q->where('student_id', $user->student_id);
                });
            }
        ])->first();

        return response()->json([
            'classCourse' => $classCourse,
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = $request->user();
            $classCourse = ClassCourse::select(
                $this->classCourse->getTable() . '.class_course_id AS id',
                (new Instructor)->getTable() . '.instructor_id',
                (new Instructor)->getTable() . '.full_name AS instructor_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name'
            )
                ->join((new Instructor)->getTable(), $this->classCourse->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
                ->join((new Course)->getTable(), $this->classCourse->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new ClassModel)->getTable(), $this->classCourse->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Major)->getTable(), (new ClassModel)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->classCourse->getTable() . '.deleted_at')
                ->where($this->classCourse->getTable() . '.class_course_id', $id)
                ->first();

            if ($user->role_id == 3 && $classCourse) {
                $classCourse->where($this->classCourse->getTable() . '.instructor_id', $user->instructor_id);
            }

            if (!$classCourse) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class course not found',
                    'error' => 'The requested class course does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'classCourse' => $classCourse,
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
            $classCourse = $this->classCourse::find($id);

            if (!$classCourse) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class course not found',
                ], 404);
            }

            $classCourse->class_id = $request->input('class_id');
            $classCourse->course_id = $request->input('course_id');
            $classCourse->instructor_id = $request->input('instructor_id');
            $classCourse->updated_at = date('Y-m-d H:i:s');
            $classCourse->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Course Update Successfully!',
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
            $classCourse = $this->classCourse::find($id);

            if (!$classCourse) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class course not found',
                ], 404);
            }

            $classCourse->deleted_at = date('Y-m-d H:i:s');
            $classCourse->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Course Delete Successfully!',
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
