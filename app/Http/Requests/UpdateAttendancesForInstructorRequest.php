<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendancesForInstructorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.*.attendance_id' => 'required|integer',
            'data.*.attendance_status' => 'required|boolean',
            'data.*.attendance_comment' => 'present|string',
            // 'data.*.*' => 'sometimes|prohibited',
        ];
    }
}
