<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClassCourse;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\ClassModel;
use App\Models\Major;
use Illuminate\Database\QueryException;

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

    public function edit($id)
    {
        try {
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
