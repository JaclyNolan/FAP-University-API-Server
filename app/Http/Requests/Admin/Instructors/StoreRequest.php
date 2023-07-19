<?php

namespace App\Http\Requests\Admin\Instructors;

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
            'instructor_id' => 'required|unique:instructors',
            'major_id' => 'required|exists:majors,id',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'position' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'instructor_id.required' => 'Please enter the instructor ID.',
            'instructor_id.unique' => 'The instructor ID already exists.',
            'major_id.required' => 'Please select the major.',
            'major_id.exists' => 'The selected major does not exist.',
            'full_name.required' => 'Please enter the full name.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.max' => 'The full name cannot exceed 255 characters.',
            'date_of_birth.required' => 'Please enter the date of birth.',
            'date_of_birth.date' => 'Invalid date of birth.',
            'phone_number.required' => 'Please enter the phone number.',
            'phone_number.string' => 'The phone number must be a string.',
            'gender.required' => 'Please select the gender.',
            'gender.in' => 'Invalid gender.',
            'address.required' => 'Please enter the address.',
            'address.string' => 'The address must be a string.',
            'image.image' => 'The uploaded file is not an image.',
            'image.mimes' => 'Invalid image format. Only JPEG, PNG, and JPG formats are allowed.',
            'image.max' => 'The image size cannot exceed 2MB.',
            'position.required' => 'Please enter the position.',
            'position.string' => 'The position must be a string.',
        ];
    }
}
