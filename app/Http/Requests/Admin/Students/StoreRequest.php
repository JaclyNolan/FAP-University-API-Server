<?php

namespace App\Http\Requests\Admin\Students;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'student_id' => 'required|unique:students',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'major_id' => 'required|exists:majors,id',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'status' => 'required|in:Active,Inactive',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'date_of_birth' => 'required|date',
            'academic_year' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Please enter the student ID.',
            'student_id.unique' => 'The student ID already exists.',
            'full_name.required' => 'Please enter the full name.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.max' => 'The full name cannot exceed 255 characters.',
            'gender.required' => 'Please select the gender.',
            'gender.in' => 'Invalid gender.',
            'major_id.required' => 'Please select the major.',
            'major_id.exists' => 'The selected major does not exist.',
            'address.required' => 'Please enter the address.',
            'address.string' => 'The address must be a string.',
            'phone_number.required' => 'Please enter the phone number.',
            'phone_number.string' => 'The phone number must be a string.',
            'status.required' => 'Please select the status.',
            'status.in' => 'Invalid status.',
            'image.image' => 'The uploaded file is not an image.',
            'image.mimes' => 'Invalid image format. Only JPEG, PNG, and JPG formats are allowed.',
            'image.max' => 'The image size cannot exceed 2MB.',
            'date_of_birth.required' => 'Please enter the date of birth.',
            'date_of_birth.date' => 'Invalid date of birth.',
            'academic_year.required' => 'Please enter the academic year.',
            'academic_year.string' => 'The academic year must be a string.',
        ];
    }
}
