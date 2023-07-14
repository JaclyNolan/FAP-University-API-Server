<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAttendancesForInstructorRequest;
use App\Models\Attendance;
use App\Models\ClassSchedule;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\ClassCourse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

            if ($request->has('status')) {
                $status = $request->input('status');
                $query->where($this->classSchedule->getTable() . '.status', $status);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->classSchedule->getTable() . '.class_schedule_id', 'LIKE', "$keyword")
                        ->orWhere((new ClassModel)->getTable() . '.class_name', 'LIKE', "%$keyword%")
                        ->orWhere((new ClassCourse)->getTable() . '.class_course_id', 'LIKE', "$keyword")
                        ->orWhere($this->classSchedule->getTable() . '.room', 'LIKE', "$keyword");
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

    private function buildMultipleClassSchedule(Request $request, Builder $query)
    {
        $class_id = $request->input('class_id');
        $course_id = $request->input('course_id');
        $day = $request->input('day');
        $slot = $request->input('slot');
        $status = $request->input('status');
        $keyword = $request->input('keyword');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $startDate = Carbon::createFromFormat('d/m/Y', $startDate);
            $query->whereDate('day', '>=', $startDate);
        }
        if ($endDate) {
            $endDate = Carbon::createFromFormat('d/m/Y', $endDate);
            $query->whereDate('day', '<=', $endDate);
        }
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
        if ($day) {
            $query->where('day', $day);
        }
        if ($slot) {
            $query->where('slot', $slot);
        }
        if ($status) {
            $query->where('status', $status);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('day', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('classCourse.course', function ($q) use ($keyword) {
                        $q->where('course_name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('classCourse.class', function ($q) use ($keyword) {
                        $q->where('class_name', 'LIKE', "%{$keyword}%");
                    });
            });
        }
        return $query;
    }

    private function buildSingleClassSchedule(Builder $query, $id)
    {
        $query->where('class_schedule_id', $id);
        return $query;
    }

    public function indexForInstructor(Request $request)
    {
        $user = $request->user();
        $query = ClassSchedule::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassSchedule)->getTable());
        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);
        $query->select($columnsToSelect);
        // Belong to instructor
        $query->whereHas('classCourse', function ($q) use ($user) {
            $q->where('instructor_id', $user->instructor_id);
        });
        $query = $this->buildMultipleClassSchedule($request, $query);
        $classSchedules = $query->with([
            'classCourse:class_course_id,class_id,course_id',
            'classCourse.class:class_id,class_name',
            'classCourse.course:course_id,course_name',
        ])->get();

        return response()->json([
            'classSchedules' => $classSchedules,
        ], 200);
    }

    public function indexForStudent(Request $request)
    {
        $user = $request->user();
        $query = ClassSchedule::query();
        // Get the table columns
        $tableColumns = Schema::getColumnListing((new ClassSchedule)->getTable());
        // Exclude the timestamp columns
        $columnsToSelect = array_diff($tableColumns, ['created_at', 'updated_at', 'deleted_at']);
        $query->select($columnsToSelect);
        // Belongs to student
        $query->whereHas('attendances.classEnrollment', function ($q) use ($user) {
            $q->where('student_id', $user->student_id);
        });
        $query = $this->buildMultipleClassSchedule($request, $query);
        $classSchedules = $query->with([
            'classCourse:class_course_id,class_id,course_id',
            'classCourse.class:class_id,class_name',
            'classCourse.course:course_id,course_name',
            'attendances' => function ($q) use ($user) {
                $q->select('class_schedule_id', 'class_enrollment_id', 'attendance_status')
                    ->whereHas('classEnrollment', function ($q) use ($user) {
                        $q->where('student_id', $user->student_id);
                    });
            },
        ])->get();

        // $classSchedules->makeHidden([
        //     'class_course_id',
        // ]);

        // $classSchedules->each(function ($classSchedule) {
        //     $classSchedule->attendances->each(function ($attendance) {
        //         $attendance->makeHidden([
        //             'class_schedule_id',
        //             'class_enrollment_id',
        //             'class_enrollment.class_enrollment_id',
        //             'class_enrollment.student.student_id',
        //         ]);
        //     });
        // });

        return response()->json([
            'classSchedules' => $classSchedules,
        ], 200);
    }

    public function showAttendancesForInstructor(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassSchedule::query();
        $query->whereHas('classCourse', function ($q) use ($user) {
            $q->where('instructor_id', $user->instructor_id);
        });
        $query->where('class_schedule_id', $id);
        $query->select('class_schedule_id', 'submit_time');
        $classSchedule = $query->with([
            'attendances:attendance_id,class_schedule_id,class_enrollment_id,attendance_status,attendance_comment',
            'attendances.classEnrollment:class_enrollment_id,student_id',
            'attendances.classEnrollment.student:student_id,full_name,image',
        ])->first();

        if (!$classSchedule) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'classSchedule' => $classSchedule,
        ], 200);
    }

    public function showClassCourseForInstructor(Request $request, $id)
    {
        $user = $request->user();
        $query = ClassSchedule::query();
        $query->whereHas('classCourse', function ($q) use ($user) {
            $q->where('instructor_id', $user->instructor_id);
        });
        $query->where('class_schedule_id', $id);
        $query->select('class_schedule_id', 'class_course_id');
        $classSchedule = $query->with([
            'classCourse:class_course_id,class_id,course_id',
            'classCourse.class:class_id,class_name',
            'classCourse.course:course_id,course_name',
        ])->first();

        if (!$classSchedule) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'classSchedule' => $classSchedule,
        ], 200);
    }

    public function updateAttendancesForInstructor(UpdateAttendancesForInstructorRequest $request, $id)
    {
        $user = $request->user();
        //  "data": [
        //   {
        //       "attendance_id": 1,
        //       "attendance_status": "1",
        //       "attendance_comment": "",
        //   },...
        //  ]
        $data = $request->input('data');
        $query = ClassSchedule::query();
        $query->whereHas('classCourse', function ($q) use ($user) {
            $q->where('instructor_id', $user->instructor_id);
        });
        $query->where('class_schedule_id', $id);
        $query->select('class_schedule_id');
        /** @var ClassSchedule $classSchedule */
        $classSchedule = $query->with([
            'attendances',
        ])->first();

        if (!$classSchedule) return response()->json([
            'message' => "Invalid id"
        ], 400);

        /** @var Collection $attendances */
        $attendances = $classSchedule->attendances;

        DB::beginTransaction();
        foreach ($data as $attendance) {
            /** @var Attendance $matchingAttendanceModel */
            $matchingAttendanceModel = $attendances->find($attendance['attendance_id']);
            if ($matchingAttendanceModel) {
                $matchingAttendanceModel->attendance_status = $attendance['attendance_status'];
                $matchingAttendanceModel->attendance_comment = $attendance['attendance_comment'] ? $attendance['attendance_comment'] : "";
                $matchingAttendanceModel->updated_at = Carbon::now();
                $matchingAttendanceModel->save();
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => "Bad Request"
                ], 400);
            }
        }
        $classSchedule->submit_time = Carbon::now();
        $classSchedule->save();
        DB::commit();
        return response()->json('', 204);
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
