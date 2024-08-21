<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\User;
use App\Models\UserField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = Field::all();
        for($i = 0; $i < 100; $i++){
           $user = User::create([
            'email' => fake()->email,
            'name' => fake()->name,
            'password' => bcrypt('admin123'),
            'phone' => fake()->phoneNumber,
            'job' => fake()->jobTitle,
            'username' => fake()->userName,
            'picture' => 'default'.rand(1, 3).'.png',
            'registration_cost' => rand(100000, 125000)
           ]);

           $fields_3 = $fields->random(3);
           foreach($fields_3 as $field){
               UserField::create([
                   'user_id' => $user->id,
                   'field_id' => $field->id
               ]);
           }
        }
    }
}
