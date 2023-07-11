<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Major;
use Illuminate\Database\QueryException;

class InstructorController extends Controller
{
    //
    private $instructor;

    public function __construct()
    {
        $this->instructor = new Instructor;
    }

    public function index(Request $request)
    {
        try {
            $query = Instructor::select(
                $this->instructor->getTable() . '.instructor_id AS id',
                $this->instructor->getTable() . '.image',
                $this->instructor->getTable() . '.full_name',
                $this->instructor->getTable() . '.date_of_birth AS Dob',
                (new User)->getTable() . '.email',
                $this->instructor->getTable() . '.gender',
                $this->instructor->getTable() . '.position',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
                $this->instructor->getTable() . '.phone_number',
                $this->instructor->getTable() . '.address'
            )
                ->leftJoin((new User)->getTable(), $this->instructor->getTable() . '.instructor_id', '=', (new User)->getTable() . '.instructor_id')
                ->join((new Major)->getTable(), $this->instructor->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->instructor->getTable() . '.deleted_at')
                ->orderBy($this->instructor->getTable() . '.instructor_id');

            if ($request->has('gender')) {
                $gender = $request->input('gender');
                $query->where($this->instructor->getTable() . '.gender', $gender);
            }

            if ($request->has('major')) {
                $majorId = $request->input('major');
                $query->where((new Major)->getTable() . '.major_id', $majorId);
            }

            if ($request->has('position')) {
                $position = $request->input('position');
                $query->where($this->instructor->getTable() . '.position', $position);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->instructor->getTable() . '.instructor_id', 'LIKE', "%$keyword%")
                        ->orWhere($this->instructor->getTable() . '.full_name', 'LIKE', "%$keyword%")
                        ->orWhere((new User)->getTable() . '.email', 'LIKE', "%$keyword%")
                        ->orWhere($this->instructor->getTable() . '.phone_number', 'LIKE', "%$keyword%");
                });
            }

            $instructors = $query->paginate(10);

            if ($instructors->currentPage() > $instructors->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid Page',
                    'error' => 'The requested page does not exist.',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($instructors->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'instructors' => [],
                    'total_pages' => $instructors->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'instructors' => $instructors->items(),
                'total_pages' => $instructors->lastPage(),
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Database Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->instructor->instructor_id = $request->input('instructor_id');
            $this->instructor->major_id = $request->input('major_id');
            $this->instructor->full_name = $request->input('full_name');
            $this->instructor->date_of_birth = $request->input('date_of_birth');
            $this->instructor->phone_number = $request->input('phone_number');
            $this->instructor->gender = $request->input('gender');
            $this->instructor->address = $request->input('address');
            $this->instructor->image = $request->input('image');
            $this->instructor->position = $request->input('position');
            $this->instructor->created_at = date('Y-m-d H:i:s');
            $this->instructor->save();

            return response()->json([
                'status' => 200,
                'message' => 'Instructor added Successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add instructor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $instructor = Instructor::select(
                $this->instructor->getTable() . '.instructor_id AS id',
                $this->instructor->getTable() . '.full_name',
                $this->instructor->getTable() . '.image',
                $this->instructor->getTable() . '.gender',
                $this->instructor->getTable() . '.date_of_birth AS Dob',
                (new User)->getTable() . '.email',
                (new User)->getTable() . '.username',
                $this->instructor->getTable() . '.phone_number AS phone',
                $this->instructor->getTable() . '.address',
                $this->instructor->getTable() . '.position',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name'
            )
                ->leftJoin((new User)->getTable(),  $this->instructor->getTable() . '.instructor_Id', '=', (new User)->getTable() . '.instructor_id')
                ->join((new Major)->getTable(),  $this->instructor->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->where($this->instructor->getTable() . '.instructor_id', $id)
                ->first();

            if (!$instructor) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Instructor not found',
                    'error' => 'The requested instructor does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'instructor' => $instructor,
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
            $instructor = $this->instructor::find($id);
            if (!$instructor) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Instructor not found',
                ], 404);
            }
            $instructor->full_name = $request->input('full_name');
            $instructor->date_of_birth = $request->input('date_of_birth');
            $instructor->gender = $request->input('gender');
            $instructor->address = $request->input('address');
            $instructor->phone_number = $request->input('phone_number');
            $instructor->major_id = $request->input('major_id');
            $instructor->position = $request->input('position');
            $instructor->image = $request->input('image');
            $instructor->updated_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
            $instructor->update();

            return response()->json([
                'status' => 200,
                'message' => 'Instructor Update Successfully!',
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
            $instructor = $this->instructor::find($id);
            if (!$instructor) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Instructor not found',
                ], 404);
            }
            $instructor->deleted_at = date('Y-m-d H:i:s');
            $instructor->update();

            return response()->json([
                'status' => 200,
                'message' => 'Instructor Delete Successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function detail(Request $request) {
        try {
            $instructor = $request->user()->instructor;

            if (!$instructor) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Instructor not found',
                    'error' => 'The requested instructor does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'instructor' => $instructor,
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
