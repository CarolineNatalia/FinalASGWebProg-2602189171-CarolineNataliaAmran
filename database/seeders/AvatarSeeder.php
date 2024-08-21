<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create random 5 avatar with random image in url then name
        $avatars = [
            [
                'name' => 'Avatar 1',
                'image' => 'avatar1.png',
                'price' => 50,
            ],
            [
                'name' => 'Avatar 2',
                'image' => 'avatar2.png',
                'price' => 100,
            ],
            [
                'name' => 'Avatar 3',
                'image' => 'avatar3.png',
                'price' => 1000,
            ],
            [
                'name' => 'Avatar 4',
                'image' => 'avatar4.png',
                'price' => 100000,
            ],
        ];

        foreach($avatars as $avatar){
            Avatar::create($avatar);
        }
    }
}
