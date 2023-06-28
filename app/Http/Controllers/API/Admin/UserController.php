<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Instructor;
use App\Models\Role;

class UserController extends Controller
{
    //
    private $user;
    public function __construct()
    {
        $this->user = new User;
    }

    public function index(Request $request)
    {
        $query = User::select(
            $this->user->getTable() . '.user_id AS id',
            $this->user->getTable() . '.email_avatar AS image',
            // User::raw('COALESCE(Students.image, Staffs.image, Instructors.image) AS image'),
            $this->user->getTable() . '.username',
            $this->user->getTable() . '.email',
            (new Role)->getTable() . '.role_name',
            (new Role)->getTable() . '.role_id'
        )
            ->leftJoin((new Student)->getTable(), $this->user->getTable() . '.student_id', '=', (new Student)->getTable() . '.student_id')
            ->leftJoin((new Staff)->getTable(), $this->user->getTable() . '.staff_id', '=', (new Staff)->getTable() . '.staff_id')
            ->leftJoin((new Instructor)->getTable(), $this->user->getTable() . '.instructor_id', '=', (new Instructor)->getTable() . '.instructor_id')
            ->join((new Role)->getTable(), $this->user->getTable() . '.role_id', '=', (new Role)->getTable() . '.role_id')
            ->whereNull($this->user->getTable() . '.deleted_at')
            ->orderBy($this->user->getTable() . '.user_id');

        // Áp dụng bộ lọc nếu có
        if ($request->has('role_id')) {
            $role_id = $request->input('role_id');
            $query->where($this->user->getTable() . '.role_id', $role_id);
        }
        // Áp dụng tìm kiếm từ khóa
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where($this->user->getTable() . '.username', 'LIKE', "%$keyword%")
                    ->orWhere($this->user->getTable() . '.email', 'LIKE', "%$keyword%");
            });
        }

        $users = $query->paginate(5); // Số bản ghi trên mỗi trang

        return response()->json([
            'status' => 200,
            'message'=> 'Success',
            'users' => $users->items(),
            'total_pages' => $users->lastPage(),
        ]);
    }

    public function store(Request $request)
    {
        $this->user->role_id = $request->input('role_id');
        $this->user->student_id = $request->input('student_id');
        $this->user->staff_id = $request->input('staff_id');
        $this->user->instructor_id = $request->input('instructor_id');
        $this->user->username = $request->input('username');
        $this->user->email = $request->input('email');
        $this->user->created_at = date('Y-m-d H:i:s');
        $this->user->save();

        return response()->json([
            'status' => 200,
            'message' => 'User added Successfully!',
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => 200,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $this->user::find($id);
        $user->role_id = $request->input('role_id');
        $user->student_id = $request->input('student_id');
        $user->staff_id = $request->input('staff_id');
        $user->instructor_id = $request->input('instructor_id');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->updated_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
        $user->update();

        return response()->json([
            'status' => 200,
            'message' => 'User Update Successfully!',
        ]);
    }

    public function delete($id)
    {
        $user = $this->user::find($id);
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->update();

        return response()->json([
            'status' => 200,
            'message' => 'User Delete Successfully!',
        ]);
    }
}
