<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\QueryException;

class StaffController extends Controller
{
    private $staff;

    public function __construct()
    {
        $this->staff = new Staff;
    }
    public function index(Request $request)
    {
        try {
            $query = Staff::select(
                $this->staff->getTable() . '.staff_id AS id',
                $this->staff->getTable() . '.image',
                $this->staff->getTable() . '.gender',
                $this->staff->getTable() . '.full_name',
                $this->staff->getTable() . '.date_of_birth AS Dob',
                (new User)->getTable() . '.email',
                $this->staff->getTable() . '.phone_number',
                $this->staff->getTable() . '.address',
                $this->staff->getTable() . '.position',
                $this->staff->getTable() . '.department'
            )
                ->leftJoin((new User)->getTable(), (new User)->getTable() . '.staff_id', '=', $this->staff->getTable() . '.staff_id')
                ->whereNull($this->staff->getTable() . '.deleted_at')
                ->orderBy($this->staff->getTable() . '.staff_id');

            if ($request->has('gender')) {
                $gender = $request->input('gender');
                $query->where($this->staff->getTable() . '.gender', $gender);
            }

            if ($request->has('department')) {
                $department = $request->input('department');
                $query->where($this->staff->getTable() . '.department', $department);
            }

            if ($request->has('position')) {
                $position = $request->input('position');
                $query->where($this->staff->getTable() . '.position', $position);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->staff->getTable() . '.staff_id', 'LIKE', "$keyword")
                        ->orWhere($this->staff->getTable() . '.full_name', 'LIKE', "%$keyword%")
                        ->orWhere($this->staff->getTable() . '.phone_number', 'LIKE', "%$keyword%")
                        ->orWhere((new User)->getTable() . '.email', 'LIKE', "%$keyword%");
                });
            }

            $staffs = $query->paginate(10); // Số bản ghi trên mỗi trang

            if ($staffs->currentPage() > $staffs->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid Page',
                    'error' => 'The requested page does not exist.',
                ], 400);
            }

            // Kiểm tra số lượng bản ghi trả về
            if ($staffs->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'staffs' => [],
                    'total_pages' => $staffs->lastPage(),
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'staffs' => $staffs->items(),
                'total_pages' => $staffs->lastPage(),
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
        $this->staff::beginTransaction();
        try {
            $this->staff->staff_id = $request->input('staff_id');
            $this->staff->full_name = $request->input('full_name');
            $this->staff->gender = $request->input('gender');
            $this->staff->address = $request->input('address');
            $this->staff->phone_number = $request->input('phone_number');
            $this->staff->department = $request->input('department');
            $this->staff->position = $request->input('position');
            $this->staff->image = $request->input('image');
            $this->staff->date_of_birth = $request->input('date_of_birth');
            $this->staff->created_at = date('Y-m-d H:i:s');
            $this->staff->save();
            $this->staff::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Staff added Successfully!',
            ]);
        } catch (\Exception $e) {
            $this->staff::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add staff',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $staff = Staff::select(
                $this->staff->getTable() . '.staff_id AS id',
                $this->staff->getTable() . '.image',
                $this->staff->getTable() . '.full_name',
                (new User)->getTable() . '.email',
                $this->staff->getTable() . '.phone_number',
                $this->staff->getTable() . '.gender',
                $this->staff->getTable() . '.date_of_birth AS Dob',
                $this->staff->getTable() . '.address',
                $this->staff->getTable() . '.department',
                $this->staff->getTable() . '.position'
            )
                ->join((new User)->getTable(), (new User)->getTable() . '.staff_id', '=', $this->staff->getTable() . '.staff_id')
                ->where($this->staff->getTable() . '.staff_id', $id)
                ->first();

            if (!$staff) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Staff not found',
                    'error' => 'The requested staff does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'staff' => $staff,
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
        $this->staff::beginTransaction();
        try {
            $staff = $this->staff::find($id);
            if (!$staff) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Staff not found',
                    'error' => 'The requested staff does not exist.',
                ], 404);
            }
            $staff->full_name = $request->input('full_name');
            $staff->date_of_birth = $request->input('date_of_birth');
            $staff->gender = $request->input('gender');
            $staff->address = $request->input('address');
            $staff->phone_number = $request->input('phone_number');
            $staff->image = $request->input('image');
            $staff->position = $request->input('position');
            $staff->department = $request->input('department');
            $staff->updated_at = date('Y-m-d H:i:s');
            $staff->update();
            $this->staff::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Staff Update Successfully!',
            ]);
        } catch (\Exception $e) {
            $this->staff::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        $this->staff::beginTransaction();
        try {
            $staff = $this->staff::find($id);
            if (!$staff) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Staff not found',
                    'error' => 'The requested staff does not exist.',
                ], 404);
            }
            $staff->deleted_at = date('Y-m-d H:i:s');
            $staff->update();
            $this->staff::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Staff Delete Successfully!',
            ]);
        } catch (\Exception $e) {
            $this->staff::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
