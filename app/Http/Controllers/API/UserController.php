<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::select('users.user_id AS id', User::raw('COALESCE(students.image, staffs.image, instructors.image) AS image'), 'users.username', 'users.email', 'roles.role_name')
        ->leftJoin('students', 'users.student_id', '=', 'students.student_id')
        ->leftJoin('staffs', 'users.staff_id', '=', 'staffs.staff_id')
        ->leftJoin('instructors', 'users.instructor_id', '=', 'instructors.instructor_id')
        ->join('roles', 'users.role_id', '=', 'roles.role_id')
        ->get();
        
        return response()-> json([
            'status' => 200,
            'users' => $users,
        ]);
    }
    public function store(Request $request){
        $user = new User;
        $user -> role_id = $request-> input('role_id');
        $user -> student_id = $request-> input('student_id');
        $user -> staff_id = $request-> input('staff_id');
        $user -> instructor_id = $request-> input('instructor_id');
        $user -> username = $request-> input('username');
        $user -> email = $request-> input('email');
        $user ->created_at = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
        $user -> save();

        return response()-> json([
            'status' => 200,
            'message' => 'User added Successfully!',
        ]);
    }

    public function edit($id){
        $user = User::find($id);
        return response()-> json([
            'status' => 200,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
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

    public function delete($id){
        $user = User::find($id);
        $user-> delete();
        return response()->json([
            'status' => 200,
            'message' => 'User Delete Successfully!',
        ]);
    }
}
