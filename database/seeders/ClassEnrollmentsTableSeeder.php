<?php

namespace Database\Seeders;

use App\Models\ClassCourse;
use App\Models\ClassEnrollment;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassEnrollmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Class_enrollments')->delete();

        $classEnrollments = [];

        $classCourses = ClassCourse::all();
        $students = Student::all();
        // Loop through each class course and student to generate class enrollments
        foreach ($classCourses as $classCourse) {
            $courseId =$classCourse->course->course_id;
            foreach ($students as $student) {
                $enrollment = $student->enrollments()->where('course_id', $courseId)->first();
                if (!$enrollment) continue;
                if ($enrollment->status <= 3) continue;
                // dump($enrollment->status);
                $classEnrollment = [
                    'class_course_id' => $classCourse->class_course_id,
                    'student_id' => $student->student_id,
                    'created_at' => now()->toDateTimeString(), // Get the current date and time as the created_at value
                    'updated_at' => null,
                    'deleted_at' => null,
                ];

                $classEnrollments[] = $classEnrollment;
            }
        }

        foreach ($classEnrollments as $classEnrollmentData) {
            ClassEnrollment::create($classEnrollmentData);
        }
    }
}
