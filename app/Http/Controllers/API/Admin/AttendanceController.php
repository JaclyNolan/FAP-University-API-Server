<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Course;
use App\Models\ClassSchedule;
use App\Models\ClassEnrollment;
use App\Models\ClassCourse;
use App\Models\Major;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private $attendance;
    public function __construct()
    {
        $this->attendance = new Attendance;
    }
    public function index(Request $request)
    {
        try {
            $query = Attendance::select(
                $this->attendance->getTable() . '.attendance_id AS id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_name',
                (new ClassSchedule)->getTable() . '.day',
                (new ClassSchedule)->getTable() . '.slot',
                (new ClassSchedule)->getTable() . '.room',
                $this->attendance->getTable() . '.attendance_status AS status'
            )
                ->join((new ClassEnrollment)->getTable(), $this->attendance->getTable() . '.class_enrollment_id', '=', (new ClassEnrollment)->getTable() . '.class_enrollment_id')
                ->join((new Student)->getTable(), (new ClassEnrollment)->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new ClassCourse)->getTable(), (new ClassEnrollment)->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new ClassSchedule)->getTable(), $this->attendance->getTable() . '.class_schedule_id', '=', (new ClassSchedule)->getTable() . '.class_schedule_id')
                ->orderBy($this->attendance->getTable() . '.attendance_id');
            
                if ($request->has('class')) {
                    $class = $request->input('class');
                    $query->where((new ClassModel)->getTable() . '.class_id', $class);
                }
                
                if ($request->has('course')) {
                    $course = $request->input('course');
                    $query->where((new Course)->getTable() . '.course_id', $course);
                }
                
                if ($request->has('slot')) {
                    $slot = $request->input('slot');
                    $query->where((new ClassSchedule)->getTable() . '.slot', $slot);
                }
                
                if ($request->has('room')) {
                    $room = $request->input('room');
                    $query->where((new ClassSchedule)->getTable() . '.room', $room);
                }
                
                if ($request->has('status')) {
                    $status = $request->input('status');
                    $query->where($this->attendance->getTable() . '.attendance_status', $status);
                }
                
                if ($request->has('keyword')) {
                    $keyword = $request->input('keyword');
                    $query->where(function ($q) use ($keyword) {
                        $q->where(function ($innerQuery) use ($keyword) {
                            $innerQuery->where($this->attendance->getTable() . '.attendance_id', 'LIKE', "$keyword")
                                ->orWhere((new Student)->getTable() . '.student_id', 'LIKE', "$keyword")
                                ->orWhere((new ClassModel)->getTable() . '.class_name', 'LIKE', "%$keyword%")
                                ->orWhere((new Course)->getTable() . '.course_name', 'LIKE', "%$keyword%");
                        });
                    });
                }

            $attendances = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $attendances->currentPage() > $attendances->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($attendances->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'attendances' => [],
                    'total_pages' => $attendances->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'attendances' => $attendances->items(),
                'total_pages' => $attendances->lastPage(),
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
            $attendance = Attendance::select(
                $this->attendance->getTable() . '.attendance_id AS id',
                (new Student)->getTable() . '.full_name AS student_name',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_name',
                (new ClassSchedule)->getTable() . '.day',
                (new ClassSchedule)->getTable() . '.slot',
                (new ClassSchedule)->getTable() . '.room',
                $this->attendance->getTable() . '.instructor_comment',
                $this->attendance->getTable() . '.attendance_status AS status'
            )
                ->join((new ClassEnrollment)->getTable(), $this->attendance->getTable() . '.class_enrollment_id', '=', (new ClassEnrollment)->getTable() . '.class_enrollment_id')
                ->join((new Student)->getTable(), (new ClassEnrollment)->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
                ->join((new ClassCourse)->getTable(), (new ClassEnrollment)->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->join((new ClassSchedule)->getTable(), $this->attendance->getTable() . '.class_schedule_id', '=', (new ClassSchedule)->getTable() . '.class_schedule_id')
                ->where($this->attendance->getTable() . '.attendance_id', $id)
                ->first();

            if (!$attendance) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Attendance not found',
                    'error' => 'The requested attendance does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'attendance' => $attendance,
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
            $attendance = $this->attendance::find($id);

            if (!$attendance) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Attendance not found',
                ], 404);
            }

            $attendance->attendance_status = $request->input('attendance_status');

            $attendance->updated_at = date('Y-m-d H:i:s');
            $attendance->update();

            return response()->json([
                'status' => 200,
                'message' => 'Attendance Update Successfully!',
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
