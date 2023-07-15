<?php

namespace Database\Seeders;

use App\Events\StudentCreated;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class StudentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('Students')->delete();

        $students = [
            0 =>
            array(
                'student_id' => 'BA001',
                'major_id' => '2',
                'full_name' => 'Michael Johnson',
                'date_of_birth' => '1998-09-20',
                'phone_number' => '456789120',
                'gender' => '1',
                'address' => '789 Oak St, City',
                'image' => 'imageBA3.jpg',
                'academic_year' => '4',
                'gpa' => '3.7999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'student_id' => 'BA002',
                'major_id' => '2',
                'full_name' => 'Emily Davis',
                'date_of_birth' => '2001-04-05',
                'phone_number' => '321654980',
                'gender' => '0',
                'address' => '987 Maple St, City',
                'image' => 'imageBA4.jpg',
                'academic_year' => '2',
                'gpa' => '3.3999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'student_id' => 'BA003',
                'major_id' => '2',
                'full_name' => 'Daniel Brown',
                'date_of_birth' => '1999-08-12',
                'phone_number' => '987654310',
                'gender' => '1',
                'address' => '123 Pine St, City',
                'image' => 'imageBA5.jpg',
                'academic_year' => '3',
                'gpa' => '3.6000000000000001',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'student_id' => 'BA004',
                'major_id' => '2',
                'full_name' => 'Sophia Wilson',
                'date_of_birth' => '2000-01-25',
                'phone_number' => '789456230',
                'gender' => '0',
                'address' => '654 Cedar St, City',
                'image' => 'imageBA6.jpg',
                'academic_year' => '4',
                'gpa' => '3.8999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'student_id' => 'BA005',
                'major_id' => '2',
                'full_name' => 'Ethan Anderson',
                'date_of_birth' => '1998-12-08',
                'phone_number' => '654983210',
                'gender' => '1',
                'address' => '789 Walnut St, City',
                'image' => 'imageBA7.jpg',
                'academic_year' => '2',
                'gpa' => '3.2999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'student_id' => 'BA006',
                'major_id' => '2',
                'full_name' => 'Olivia Hernandez',
                'date_of_birth' => '2001-06-18',
                'phone_number' => '321976540',
                'gender' => '0',
                'address' => '123 Birch St, City',
                'image' => 'imageBA8.jpg',
                'academic_year' => '3',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'student_id' => 'BA007',
                'major_id' => '2',
                'full_name' => 'Liam Thompson',
                'date_of_birth' => '1999-11-25',
                'phone_number' => '789654230',
                'gender' => '1',
                'address' => '789 Elm St, City',
                'image' => 'imageBA9.jpg',
                'academic_year' => '1',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 =>
            array(
                'student_id' => 'BA008',
                'major_id' => '2',
                'full_name' => 'Ava Wilson',
                'date_of_birth' => '2002-02-15',
                'phone_number' => '456789640',
                'gender' => '0',
                'address' => '654 Pine St, City',
                'image' => 'imageBA10.jpg',
                'academic_year' => '4',
                'gpa' => '3.7999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 =>
            array(
                'student_id' => 'BA009',
                'major_id' => '2',
                'full_name' => 'Noah Johnson',
                'date_of_birth' => '1998-05-30',
                'phone_number' => '987326540',
                'gender' => '1',
                'address' => '123 Walnut St, City',
                'image' => 'imageBA11.jpg',
                'academic_year' => '3',
                'gpa' => '3.3999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'student_id' => 'BA010',
                'major_id' => '2',
                'full_name' => 'Emma Davis',
                'date_of_birth' => '2001-09-09',
                'phone_number' => '654123790',
                'gender' => '0',
                'address' => '456 Cedar St, City',
                'image' => 'imageBA12.jpg',
                'academic_year' => '2',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 =>
            array(
                'student_id' => 'BA011',
                'major_id' => '2',
                'full_name' => 'William Thompson',
                'date_of_birth' => '1999-12-05',
                'phone_number' => '976541230',
                'gender' => '1',
                'address' => '789 Oak St, City',
                'image' => 'imageBA13.jpg',
                'academic_year' => '4',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 =>
            array(
                'student_id' => 'BA012',
                'major_id' => '2',
                'full_name' => 'Olivia Hernandez',
                'date_of_birth' => '2002-06-18',
                'phone_number' => '329876541',
                'gender' => '0',
                'address' => '123 Maple St, City',
                'image' => 'imageBA14.jpg',
                'academic_year' => '3',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 =>
            array(
                'student_id' => 'CS001',
                'major_id' => '1',
                'full_name' => 'John Doe',
                'date_of_birth' => '1999-05-10',
                'phone_number' => '123456789',
                'gender' => '1',
                'address' => '123 Main St, City',
                'image' => 'imageCS1.jpg',
                'academic_year' => '2',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 =>
            array(
                'student_id' => 'CS002',
                'major_id' => '1',
                'full_name' => 'Jane Smith',
                'date_of_birth' => '2000-02-15',
                'phone_number' => '987654321',
                'gender' => '0',
                'address' => '456 Elm St, City',
                'image' => 'imageCS2.jpg',
                'academic_year' => '3',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 =>
            array(
                'student_id' => 'CS003',
                'major_id' => '1',
                'full_name' => 'Michael Johnson',
                'date_of_birth' => '2001-07-20',
                'phone_number' => '555555555',
                'gender' => '1',
                'address' => '789 Oak St, City',
                'image' => 'imageCS3.jpg',
                'academic_year' => '1',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 =>
            array(
                'student_id' => 'CS004',
                'major_id' => '1',
                'full_name' => 'Emily Davis',
                'date_of_birth' => '2002-04-05',
                'phone_number' => '666666666',
                'gender' => '0',
                'address' => '987 Maple St, City',
                'image' => 'imageCS4.jpg',
                'academic_year' => '2',
                'gpa' => '3.8999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 =>
            array(
                'student_id' => 'CS005',
                'major_id' => '1',
                'full_name' => 'Daniel Brown',
                'date_of_birth' => '2000-09-12',
                'phone_number' => '777777777',
                'gender' => '1',
                'address' => '123 Pine St, City',
                'image' => 'imageCS5.jpg',
                'academic_year' => '3',
                'gpa' => '3.6000000000000001',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 =>
            array(
                'student_id' => 'CS006',
                'major_id' => '1',
                'full_name' => 'Sophia Wilson',
                'date_of_birth' => '2003-01-25',
                'phone_number' => '888888888',
                'gender' => '0',
                'address' => '654 Cedar St, City',
                'image' => 'imageCS6.jpg',
                'academic_year' => '2',
                'gpa' => '3.7999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            18 =>
            array(
                'student_id' => 'CS007',
                'major_id' => '1',
                'full_name' => 'Ethan Anderson',
                'date_of_birth' => '2001-03-08',
                'phone_number' => '999999999',
                'gender' => '1',
                'address' => '789 Walnut St, City',
                'image' => 'imageCS7.jpg',
                'academic_year' => '3',
                'gpa' => '3.3999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            19 =>
            array(
                'student_id' => 'CS008',
                'major_id' => '1',
                'full_name' => 'Olivia Hernandez',
                'date_of_birth' => '2002-06-18',
                'phone_number' => '123123231',
                'gender' => '0',
                'address' => '123 Birch St, City',
                'image' => 'imageCS8.jpg',
                'academic_year' => '4',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            20 =>
            array(
                'student_id' => 'CS009',
                'major_id' => '1',
                'full_name' => 'Liam Thompson',
                'date_of_birth' => '2000-11-25',
                'phone_number' => '456456456',
                'gender' => '1',
                'address' => '789 Elm St, City',
                'image' => 'imageCS9.jpg',
                'academic_year' => '2',
                'gpa' => '3.8999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            21 =>
            array(
                'student_id' => 'CS010',
                'major_id' => '1',
                'full_name' => 'Ava Wilson',
                'date_of_birth' => '2003-02-15',
                'phone_number' => '789789789',
                'gender' => '0',
                'address' => '654 Pine St, City',
                'image' => 'imageCS10.jpg',
                'academic_year' => '4',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            22 =>
            array(
                'student_id' => 'CS011',
                'major_id' => '1',
                'full_name' => 'Noah Johnson',
                'date_of_birth' => '2001-05-30',
                'phone_number' => '321321323',
                'gender' => '1',
                'address' => '123 Walnut St, City',
                'image' => 'imageCS11.jpg',
                'academic_year' => '3',
                'gpa' => '3.2999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            23 =>
            array(
                'student_id' => 'CS012',
                'major_id' => '1',
                'full_name' => 'Emma Davis',
                'date_of_birth' => '2002-09-09',
                'phone_number' => '654654654',
                'gender' => '0',
                'address' => '456 Cedar St, City',
                'image' => 'imageCS12.jpg',
                'academic_year' => '1',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            24 =>
            array(
                'student_id' => 'ME001',
                'major_id' => '3',
                'full_name' => 'Robert Anderson',
                'date_of_birth' => '1999-08-25',
                'phone_number' => '789124560',
                'gender' => '1',
                'address' => '456 Pine St, City',
                'image' => 'imageME5.jpg',
                'academic_year' => '3',
                'gpa' => '3.6000000000000001',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            25 =>
            array(
                'student_id' => 'ME002',
                'major_id' => '3',
                'full_name' => 'Sophia Wilson',
                'date_of_birth' => '2000-01-12',
                'phone_number' => '654987210',
                'gender' => '0',
                'address' => '654 Cedar St, City',
                'image' => 'imageME6.jpg',
                'academic_year' => '4',
                'gpa' => '3.8999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            26 =>
            array(
                'student_id' => 'ME003',
                'major_id' => '3',
                'full_name' => 'Daniel Thompson',
                'date_of_birth' => '1999-05-18',
                'phone_number' => '987653210',
                'gender' => '1',
                'address' => '123 Oak St, City',
                'image' => 'imageME7.jpg',
                'academic_year' => '2',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            27 =>
            array(
                'student_id' => 'ME004',
                'major_id' => '3',
                'full_name' => 'Olivia Davis',
                'date_of_birth' => '2001-02-01',
                'phone_number' => '321654870',
                'gender' => '0',
                'address' => '456 Elm St, City',
                'image' => 'imageME8.jpg',
                'academic_year' => '3',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            28 =>
            array(
                'student_id' => 'ME005',
                'major_id' => '3',
                'full_name' => 'William Johnson',
                'date_of_birth' => '1998-11-10',
                'phone_number' => '456891230',
                'gender' => '1',
                'address' => '789 Maple St, City',
                'image' => 'imageME9.jpg',
                'academic_year' => '4',
                'gpa' => '3.7999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            29 =>
            array(
                'student_id' => 'ME006',
                'major_id' => '3',
                'full_name' => 'Emma Anderson',
                'date_of_birth' => '2001-06-25',
                'phone_number' => '487326540',
                'gender' => '0',
                'address' => '123 Cedar St, City',
                'image' => 'imageME10.jpg',
                'academic_year' => '2',
                'gpa' => '3.3999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            30 =>
            array(
                'student_id' => 'ME007',
                'major_id' => '3',
                'full_name' => 'Liam Hernandez',
                'date_of_birth' => '1999-10-12',
                'phone_number' => '654973210',
                'gender' => '1',
                'address' => '456 Walnut St, City',
                'image' => 'imageME11.jpg',
                'academic_year' => '3',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            31 =>
            array(
                'student_id' => 'ME008',
                'major_id' => '3',
                'full_name' => 'Ava Thompson',
                'date_of_birth' => '2002-01-05',
                'phone_number' => '321987540',
                'gender' => '0',
                'address' => '789 Pine St, City',
                'image' => 'imageME12.jpg',
                'academic_year' => '4',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            32 =>
            array(
                'student_id' => 'ME009',
                'major_id' => '3',
                'full_name' => 'Noah Davis',
                'date_of_birth' => '1998-04-20',
                'phone_number' => '789654130',
                'gender' => '1',
                'address' => '123 Elm St, City',
                'image' => 'imageME13.jpg',
                'academic_year' => '1',
                'gpa' => '3.2999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            33 =>
            array(
                'student_id' => 'ME010',
                'major_id' => '3',
                'full_name' => 'Sophia Johnson',
                'date_of_birth' => '2001-09-15',
                'phone_number' => '456796540',
                'gender' => '0',
                'address' => '456 Maple St, City',
                'image' => 'imageME14.jpg',
                'academic_year' => '2',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            34 =>
            array(
                'student_id' => 'ME011',
                'major_id' => '3',
                'full_name' => 'Michael Anderson',
                'date_of_birth' => '1999-12-30',
                'phone_number' => '987316540',
                'gender' => '1',
                'address' => '789 Cedar St, City',
                'image' => 'imageME15.jpg',
                'academic_year' => '4',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            35 =>
            array(
                'student_id' => 'ME012',
                'major_id' => '3',
                'full_name' => 'Oliver Hernandez',
                'date_of_birth' => '2002-03-18',
                'phone_number' => '321976541',
                'gender' => '0',
                'address' => '123 Walnut St, City',
                'image' => 'imageME16.jpg',
                'academic_year' => '3',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            36 =>
            array(
                'student_id' => 'P001',
                'major_id' => '4',
                'full_name' => 'William Thompson',
                'date_of_birth' => '1998-12-05',
                'phone_number' => '987321540',
                'gender' => '1',
                'address' => '789 Walnut St, City',
                'image' => 'imageP7.jpg',
                'academic_year' => '2',
                'gpa' => '3.2999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            37 =>
            array(
                'student_id' => 'P002',
                'major_id' => '4',
                'full_name' => 'Olivia Hernandez',
                'date_of_birth' => '2001-06-18',
                'phone_number' => '124567891',
                'gender' => '0',
                'address' => '123 Birch St, City',
                'image' => 'imageP8.jpg',
                'academic_year' => '2',
                'gpa' => '3.2999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            38 =>
            array(
                'student_id' => 'P003',
                'major_id' => '4',
                'full_name' => 'Emma Davis',
                'date_of_birth' => '1999-09-10',
                'phone_number' => '789654210',
                'gender' => '0',
                'address' => '456 Cedar St, City',
                'image' => 'imageP9.jpg',
                'academic_year' => '3',
                'gpa' => '3.6000000000000001',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            39 =>
            array(
                'student_id' => 'P004',
                'major_id' => '4',
                'full_name' => 'Liam Anderson',
                'date_of_birth' => '2000-01-15',
                'phone_number' => '328976541',
                'gender' => '1',
                'address' => '789 Walnut St, City',
                'image' => 'imageP10.jpg',
                'academic_year' => '2',
                'gpa' => '3.3999999999999999',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            40 =>
            array(
                'student_id' => 'P005',
                'major_id' => '4',
                'full_name' => 'Sophia Hernandez',
                'date_of_birth' => '1998-08-20',
                'phone_number' => '651237890',
                'gender' => '0',
                'address' => '123 Pine St, City',
                'image' => 'imageP11.jpg',
                'academic_year' => '4',
                'gpa' => '3.7999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            41 =>
            array(
                'student_id' => 'P006',
                'major_id' => '4',
                'full_name' => 'Oliver Thompson',
                'date_of_birth' => '2001-03-05',
                'phone_number' => '987543211',
                'gender' => '1',
                'address' => '456 Elm St, City',
                'image' => 'imageP12.jpg',
                'academic_year' => '3',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            42 =>
            array(
                'student_id' => 'P007',
                'major_id' => '4',
                'full_name' => 'Ava Davis',
                'date_of_birth' => '1999-10-12',
                'phone_number' => '321654871',
                'gender' => '0',
                'address' => '789 Cedar St, City',
                'image' => 'imageP13.jpg',
                'academic_year' => '4',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            43 =>
            array(
                'student_id' => 'P008',
                'major_id' => '4',
                'full_name' => 'Noah Anderson',
                'date_of_birth' => '2000-05-25',
                'phone_number' => '654791231',
                'gender' => '1',
                'address' => '123 Maple St, City',
                'image' => 'imageP14.jpg',
                'academic_year' => '2',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            44 =>
            array(
                'student_id' => 'P009',
                'major_id' => '4',
                'full_name' => 'Mia Hernandez',
                'date_of_birth' => '1998-12-30',
                'phone_number' => '987316541',
                'gender' => '0',
                'address' => '456 Walnut St, City',
                'image' => 'imageP15.jpg',
                'academic_year' => '3',
                'gpa' => '3.2999999999999998',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            45 =>
            array(
                'student_id' => 'P010',
                'major_id' => '4',
                'full_name' => 'Ethan Thompson',
                'date_of_birth' => '2001-07-15',
                'phone_number' => '321876542',
                'gender' => '1',
                'address' => '789 Cedar St, City',
                'image' => 'imageP16.jpg',
                'academic_year' => '2',
                'gpa' => '3.7000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            46 =>
            array(
                'student_id' => 'P011',
                'major_id' => '4',
                'full_name' => 'Isabella Davis',
                'date_of_birth' => '1999-11-20',
                'phone_number' => '659873211',
                'gender' => '0',
                'address' => '123 Pine St, City',
                'image' => 'imageP17.jpg',
                'academic_year' => '4',
                'gpa' => '3.5',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            47 =>
            array(
                'student_id' => 'P012',
                'major_id' => '4',
                'full_name' => 'James Anderson',
                'date_of_birth' => '2000-04-05',
                'phone_number' => '987543212',
                'gender' => '1',
                'address' => '456 Elm St, City',
                'image' => 'imageP18.jpg',
                'academic_year' => '3',
                'gpa' => '3.2000000000000002',
                'status' => '1',
                'created_at' => '2023-06-07 10:02:33.853',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ];

        foreach ($students as $studentData) {
            $studentModel = Student::create($studentData);
            // Event::dispatch(new StudentCreated($studentModel));
        }
    }
}
