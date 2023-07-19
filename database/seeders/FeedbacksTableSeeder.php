<?php

namespace Database\Seeders;

use App\Models\ClassEnrollment;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbacksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('Feedbacks')->delete();

        $feedbacks = [];
        $classEnrollments = ClassEnrollment::all();

        foreach ($classEnrollments as $index => $classEnrollment) {
            $feedbacks[] = [
                'class_enrollment_id' => $classEnrollment->class_enrollment_id,
                'feedback_content' => 'Sample feedback ' . $index + 1,
                'created_at' => now()->toDateString(),
            ];
        }

        foreach ($feedbacks as $feedback) {
            Feedback::create($feedback);
        }
    }
}
