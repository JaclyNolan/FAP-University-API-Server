<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClassModel;
use App\Models\Major;
use Illuminate\Database\QueryException;

class ClassController extends Controller
{
    private $class;
    public function __construct()
    {
        $this->class = new ClassModel;
    }

    public function index(Request $request)
    {
        try {
            $query = ClassModel::select(
                $this->class->getTable() . '.class_id AS id',
                $this->class->getTable() . '.class_name AS name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
            )
                ->join((new Major)->getTable(), $this->class->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->class->getTable() . '.deleted_at')
                ->orderBy($this->class->getTable() . '.class_id');

            if ($request->has('major')) {
                $major = $request->input('major');
                $query->where($this->class->getTable() . '.major_id', $major);
            }

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where($this->class->getTable() . '.class_name', 'LIKE', "%$keyword%")
                        ->orWhere($this->class->getTable() . '.class_id', 'LIKE', "$keyword");
                });
            }

            $class = $query->paginate(10); // Số bản ghi trên mỗi trang
            // Kiểm tra xem trang hiện tại có lớn hơn tổng số trang không
            if ($request->has('page') && $class->currentPage() > $class->lastPage()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Page out of range',
                ], 400);
            }
            // Kiểm tra số lượng bản ghi trả về
            if ($class->count() === 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found.',
                    'class' => [],
                    'total_pages' => $class->lastPage(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'class' => $class->items(),
                'total_pages' => $class->lastPage(),
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
            $this->class->class_name = $request->input('class_name');
            $this->class->major_id = $request->input('major_id');
            $this->class->created_at = date('Y-m-d H:i:s');
            $this->class->save();

            return response()->json([
                'status' => 200,
                'message' => 'Class added successfully!',
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
            $class = ClassModel::select(
                $this->class->getTable() . '.class_id AS id',
                $this->class->getTable() . '.class_name AS name',
                (new Major)->getTable() . '.major_id',
                (new Major)->getTable() . '.major_name',
            )
                ->join((new Major)->getTable(), $this->class->getTable() . '.major_id', '=', (new Major)->getTable() . '.major_id')
                ->whereNull($this->class->getTable() . '.deleted_at')
                ->where($this->class->getTable() . '.class_id', $id)
                ->first();

            if (!$class) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class not found',
                    'error' => 'The requested class does not exist.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'class' => $class,
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
            $class = $this->class::find($id);

            // Kiểm tra xem khóa học có tồn tại không
            if (!$class) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class not found',
                ], 404);
            }

            $class->class_name = $request->input('class_name');
            $class->major_id = $request->input('major_id');
            $class->updated_at = date('Y-m-d H:i:s');
            $class->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Update Successfully!',
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
            $class = $this->class::find($id);

            // Kiểm tra xem khóa học có tồn tại không
            if (!$class) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Class not found',
                ], 404);
            }

            $class->deleted_at = date('Y-m-d H:i:s');
            $class->update();

            return response()->json([
                'status' => 200,
                'message' => 'Class Delete Successfully!',
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
