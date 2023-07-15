<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RolesTableSeeder::class);
        $this->call(NewsContentsTableSeeder::class);
        $this->call(MajorsTableSeeder::class);
        $this->call(ClassTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(InstructorsTableSeeder::class);
        $this->call(StaffsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(EnrollmentsTableSeeder::class);
        $this->call(ClassCoursesTableSeeder::class);
        $this->call(ClassEnrollmentsTableSeeder::class);
        $this->call(ClassSchedulesTableSeeder::class);
        // $this->call(AttendancesTableSeeder::class);
        $this->call(FeedbacksTableSeeder::class);
        // $this->call(GradesTableSeeder::class);
    }
}
