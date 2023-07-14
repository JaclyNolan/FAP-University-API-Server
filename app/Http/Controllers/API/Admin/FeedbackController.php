<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\Course;
use App\Models\ClassEnrollment;
use App\Models\ClassModel;
use App\Models\ClassCourse;
use App\Models\Major;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FeedbackController extends Controller
{
    //
    private $feedback;
    public function __construct()
    {
        $this->feedback = new Feedback;
    }
    public function index(Request $request)
    {
        try {
            $query = Feedback::select(
                $this->feedback->getTable() . '.feedback_id AS id',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                (new Instructor)->getTable() . '.instructor_id',
                (new Instructor)->getTable() . '.full_name AS instructor_name',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name'
            )
                ->join((new ClassEnrollment)->getTable(), $this->feedback->getTable() . '.class_enrollment_id', '=', (new ClassEnrollment)->getTable() . '.class_enrollment_id')
                ->join((new Student)->getTable(), (new ClassEnrollment)->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new ClassCourse)->getTable(), (new ClassEnrollment)->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new Instructor)->getTable(), (new ClassCourse)->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
                ->join((new Major)->getTable(), (new Course)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->orderBy($this->feedback->getTable() . '.feedback_id');


            if ($request->has('major')) {
                $major = $request->input('major');
                $query->where((new Major)->getTable() . '.major_id', $major);
            }

            if ($request->has('course')) {
                $course = $request->input('course');
                $query->where((new Course)->getTable() . '.course_id', $course);
            }

            if ($request->has('class')) {
                $class = $request->input('class');
                $query->where((new ClassModel)->getTable() . '.class_id', $class);
            }

            if ($request->has('instructor')) {
                $instructor = $request->input('instructor');
                $query->where((new Instructor)->getTable() . '.instructor_id', $instructor);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where(function ($innerQuery) use ($keyword) {
                        $innerQuery->where($this->feedback->getTable() . '.feedback_id', 'LIKE', "%$keyword%")
                            ->orWhere((new Instructor)->getTable() . '.full_name', 'LIKE', "%$keyword%")
                            ->orWhere((new Course)->getTable() . '.course_name', 'LIKE', "%$keyword%")
                            ->orWhere((new ClassModel)->getTable() . '.class_name', 'LIKE', "%$keyword%")
                            ->orWhere((new Student)->getTable() . '.student_id', 'LIKE', "%$keyword%");
                    });
                });
            }


            $feedbacks = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $feedbacks->currentPage() > $feedbacks->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($feedbacks->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'feedbacks' => [],
                    'total_pages' => $feedbacks->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'feedbacks' => $feedbacks->items(),
                'total_pages' => $feedbacks->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to query the database',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexForInstructor(Request $request)
    {
        $classCourseId = $request->input('class_course_id');
        $user = $request->user();
        $query = Feedback::query();
        //Belong to instructor
        $query->whereHas('classEnrollment.classCourse', function ($q) use ($user) {
            $q->where('instructor_id', $user->instructor_id);
        });
        //Filter
        if ($classCourseId) {
            $query->whereHas('classEnrollment.classCourse', function ($q) use ($classCourseId) {
                $q->where('class_course_id', $classCourseId);
            });
        }

        $feedbacks = $query->with([
            'classEnrollment:class_enrollment_id,class_course_id,student_id',
            'classEnrollment.student:student_id,full_name',
            'classEnrollment.classCourse:class_course_id,class_id,course_id',
            'classEnrollment.classCourse.class:class_id,class_name',
            'classEnrollment.classCourse.course:course_id,course_name',
        ])->orderByDesc('created_at')->get();

        return response()->json([
            'feedbacks' => $feedbacks,
        ], 200);
    }

    public function edit($id)
    {
        try {
            $feedback = Feedback::select(
                $this->feedback->getTable() . '.feedback_id AS id',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                (new Instructor)->getTable() . '.instructor_id',
                (new Instructor)->getTable() . '.full_name AS instructor_name',
                (new Student)->getTable() . '.student_id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                $this->feedback->getTable() . '.feedback_content',
            )
                ->join((new ClassEnrollment)->getTable(), $this->feedback->getTable() . '.class_enrollment_id', '=', (new ClassEnrollment)->getTable() . '.class_enrollment_id')
                ->join((new Student)->getTable(), (new ClassEnrollment)->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new ClassCourse)->getTable(), (new ClassEnrollment)->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new Instructor)->getTable(), (new ClassCourse)->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
                ->join((new Major)->getTable(), (new Course)->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->orderBy($this->feedback->getTable() . '.feedback_id')
                ->where($this->feedback->getTable() . '.feedback_id', $id)
                ->first();

            if (!$feedback) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Feedback not found',
                    'error' => 'The requested feedback does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'feedback' => $feedback,
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
