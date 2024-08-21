<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // use random to generate work field
        $fields = [
            'Accounting',
            'Agriculture',
            'Architecture',
            'Arts',
            'Biology',
            'Business',
            'Chemistry',
            'Computer Science',
            'Dentistry',
            'Economics',
            'Education',
            'Engineering',
            'Geography',
            'History',
            'Law',
            'Literature',
            'Mathematics',
            'Medicine',
            'Music',
            'Nursing',
            'Pharmacy',
            'Philosophy',
            'Physics',
            'Political Science',
            'Psychology',
            'Sociology',
            'Statistics',
            'Theology',
            'Veterinary Medicine',
        ];

        foreach ($fields as $field) {
            Field::create(['name' => $field]);
        }
    }
}
