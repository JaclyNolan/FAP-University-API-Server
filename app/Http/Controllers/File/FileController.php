<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function store(Request $request)
    {
        $file = $request->file('file');
        $imageName = time() . '.' . $file->extension();
        $imagePath = public_path('files/');

        $file->move($imagePath, $imageName);

        return response()->json([
            "success" => true,
            "message" => "Image has been uploaded successfully.",
            "filename" => $imageName
        ]);
    }

    public function getFile($filename)
    {
        $imagePath = public_path('files/' . $filename);

        if (file_exists($imagePath)) {
            // Trả về file ảnh
            return response()->file($imagePath);
        }

        // Trả về thông báo lỗi nếu file không tồn tại
        return response()->json([
            "success" => false,
            "message" => "Image not found."
        ], 404);
    }

}
