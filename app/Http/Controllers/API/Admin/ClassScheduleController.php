<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\ClassCourse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    private $classSchedule;
    public function __construct()
    {
        $this->classSchedule = new ClassSchedule;
    }

    public function index(Request $request)
    {
        try {
            $query = ClassSchedule::select(
                $this->classSchedule->getTable() . '.class_schedule_id AS id',
                (new ClassCourse)->getTable() . '.class_course_id',
                (new ClassModel)->getTable() . '.class_id',
                (new ClassModel)->getTable() . '.class_name',
                (new Course)->getTable() . '.course_id',
                (new Course)->getTable() . '.course_name',
                $this->classSchedule->getTable() . '.day',
                $this->classSchedule->getTable() . '.slot',
                $this->classSchedule->getTable() . '.room',
                $this->classSchedule->getTable() . '.status',
                $this->classSchedule->getTable() . '.created_at',
            )
                ->join((new ClassCourse)->getTable(), $this->classSchedule->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->join((new ClassModel)->getTable(), (new ClassCourse)->getTable() . '.class_id', '=', (new ClassModel)->getTable() . '.class_id')
                ->join((new Course)->getTable(), (new ClassCourse)->getTable() . '.course_id', '=', (new Course)->getTable() . '.course_id')
                ->whereNull($this->classSchedule->getTable() . '.deleted_at')
                ->orderBy($this->classSchedule->getTable() . '.class_schedule_id');

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
                    $query->where($this->classSchedule->getTable() . '.slot', $slot);
                }
                
                if ($request->has('room')) {
                    $room = $request->input('room');
                    $query->where($this->classSchedule->getTable() . '.room', $room);
                }
                
                if ($request->has('status')) {
                    $status = $request->input('status');
                    $query->where($this->classSchedule->getTable() . '.status', $status);
                }
                
                if ($request->has('keyword')) {
                    $keyword = $request->input('keyword');
                    $query->where(function ($q) use ($keyword) {
                        $q->where($this->classSchedule->getTable() . '.class_schedule_id', 'LIKE', "%$keyword%")
                            ->orWhere((new ClassModel)->getTable() . '.class_name', 'LIKE', "%$keyword%")
                            ->orWhere((new ClassCourse)->getTable() . '.class_course_id', 'LIKE', "$keyword");
                    });
                }

            $classSchedules = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $classSchedules->currentPage() > $classSchedules->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($classSchedules->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'classSchedules' => [],
                    'total_pages' => $classSchedules->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'classSchedules' => $classSchedules->items(),
                'total_pages' => $classSchedules->lastPage(),
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
            $this->classSchedule->class_course_id = $request->input('class_course_id');
            $this->classSchedule->day = $request->input('day');
            $this->classSchedule->slot = $request->input('slot');
            $this->classSchedule->room = $request->input('room');
            $this->classSchedule->status = $request->input('status');
            $this->classSchedule->created_at = date('Y-m-d H:i:s');
            $this->classSchedule->save();

            return response()->json([
                'status' => 200,
                'message' => 'Class Schedule added successfully!',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add class',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $classSchedule = ClassSchedule::select(
                $this->classSchedule->getTable() . '.class_schedule_id AS id',
                $this->classSchedule->getTable() . '.class_course_id',
                $this->classSchedule->getTable() . '.day',
                $this->classSchedule->getTable() . '.slot',
                $this->classSchedule->getTable() . '.room',
                $this->classSchedule->getTable() . '.status',
                $this->classSchedule->getTable() . '.created_at',
                $this->classSchedule->getTable() . '.updated_at',
            )
                ->join((new ClassCourse)->getTable(), $this->classSchedule->getTable() . '.class_course_id', '=', (new ClassCourse)->getTable() . '.class_course_id')
                ->where($this->classSchedule->getTable() . '.class_schedule_id', $id)
                ->whereNull($this->classSchedule->getTable() . '.deleted_at')
                ->first();

            if (!$classSchedule) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class schedule not found',
                    'error' => 'The requested class class schedule does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'classSchedule' => $classSchedule,
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
            $classSchedule = $this->classSchedule::find($id);

            if (!$classSchedule) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class schedule not found',
                ], 404);
            }

            $classSchedule->class_course_id = $request->input('class_course_id');
            $classSchedule->day = $request->input('day');
            $classSchedule->slot = $request->input('slot');
            $classSchedule->room = $request->input('room');
            $classSchedule->status = $request->input('status');

            $classSchedule->updated_at = date('Y-m-d H:i:s');
            $classSchedule->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Schedule Update Successfully!',
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
            $classSchedule = $this->classSchedule::find($id);

            if (!$classSchedule) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class schedule not found',
                ], 404);
            }

            $classSchedule->deleted_at = date('Y-m-d H:i:s');
            $classSchedule->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Schedule Delete Successfully!',
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
