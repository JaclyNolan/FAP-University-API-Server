<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Major;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;

class CourseController extends Controller
{
    //
    private $course;

    public function __construct()
    {
        $this->course = new Course;
    }

    public function index(Request $request)
    {
        try {
            $query = Course::select(
                $this->course->getTable() . '.course_id AS id',
                $this->course->getTable() . '.course_name AS name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                $this->course->getTable() . '.credits',
                Course::raw('credits * 300 as tuition_fee')
            )
                ->join((new Major)->getTable(), $this->course->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->course->getTable() . '.deleted_at')
                ->orderBy($this->course->getTable() . '.course_id');

            if ($request->has('major')) {
                $major = $request->input('major');
                $query->where($this->course->getTable() . '.major_id', $major);
            }

            if ($request->has('credit')) {
                $credit = $request->input('credit');
                $query->where($this->course->getTable() . '.credits', $credit);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->course->getTable() . '.course_name', 'LIKE', "%$keyword%")
                        ->orWhere($this->course->getTable() . '.course_id', 'LIKE', "$keyword");
                });
            }

            $courses = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $courses->currentPage() > $courses->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($courses->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'courses' => [],
                    'total_pages' => $courses->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'courses' => $courses->items(),
                'total_pages' => $courses->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to query the database',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function buildMultipleCourses(Request $request, Builder $query)
    {
        $credits = $request->input('status');
        $keyword = $request->input('keyword');

        if ($credits) {
            $query->where('credits', $credits);
        }

        if ($keyword) {
            $query->where('course_name', 'LIKE', "%{$keyword}%");
        }

        return $query;
    }

    // public function indexForStudent(Request $request)
    // {
    //     $enrollmentStatus = $request->input('enrollment_status');
    //     $user = $request->user();
    //     $query = Course::query();
    //     // Get the table columns
    //     $tableColumns = Schema::getColumnListing((new Course)->getTable());
    //     // Exclude the timestamp columns
    //     $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);
    //     $query->select($columnsToSelect);
    //     //Belong to the major that the student is in
    //     $query->where('major_id', $user->student->major_id);
    //     $query = $this->buildMultipleCourses($request, $query);
    //     //Filter enrollmentStatus
    //     if ($enrollmentStatus) {
    //         $query->whereHas('enrollments', function ($q) use ($user, $enrollmentStatus) {
    //             $q->where('student_id', $user->student_id)
    //                 ->where('status', $enrollmentStatus);
    //         });
    //     }
    //     $courses = $query->with([
    //         'enrollments' => function ($q) use ($user) {
    //             $q->select('enrollment_id', 'student_id', 'course_id', 'status', 'status_name')
    //                 ->where('student_id', $user->student_id);
    //         },
    //     ])->get();

    //     return response()->json([
    //         'courses' => $courses,
    //     ], 200);
    // }

    public function store(Request $request)
    {
        try {
            $this->course->course_name = $request->input('course_name');
            $this->course->major_id = $request->input('major_id');
            $this->course->credits = $request->input('credits');
            $this->course->created_at = date('Y-m-d H:i:s');
            $this->course->save();

            return response()->json([
                'status' => 200,
                'message' => 'Course added successfully!',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $course = Course::select(
                $this->course->getTable() . '.course_id AS id',
                $this->course->getTable() . '.course_name AS name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                $this->course->getTable() . '.credits',
                Course::raw('courses.credits * 300 as tuition_fee')
            )
                ->join((new Major)->getTable(), $this->course->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->where($this->course->getTable() . '.course_id', $id)
                ->whereNull($this->course->getTable() . '.deleted_at')
                ->first();

            if (!$course) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Course not found',
                    'error' => 'The requested course does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'course' => $course,
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
            $course = $this->course::find($id);

            // Kiểm tra xem khóa học có tồn tại không
            if (!$course) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Course not found',
                ], 404);
            }

            $course->course_name = $request->input('course_name');
            $course->major_id = $request->input('major_id');
            $course->credits = $request->input('credits');
            $course->updated_at = date('Y-m-d H:i:s');
            $course->update();

            return response()->json([
                'status' => 200,
                'message' => 'Course Update Successfully!',
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
            $course = $this->course::find($id);

            // Kiểm tra xem khóa học có tồn tại không
            if (!$course) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Course not found',
                ], 404);
            }

            $course->deleted_at = date('Y-m-d H:i:s');
            $course->update();

            return response()->json([
                'status' => 200,
                'message' => 'Course Delete Successfully!',
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
