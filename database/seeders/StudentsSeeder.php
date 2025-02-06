<?php

namespace Database\Seeders;

use App\Models\Students;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            Students::create([
                'first_name' => $user->name,  // Assuming first name is stored in `name`
                'last_name' => 'Doe',  // Example, you might want to customize this
                'roll_no' => '17R11A0575',  // Example roll number, customize as needed
                'college_mail_id' => strtolower($user->name) . '@gcet.edu.in',  // Example email format
                'stream' => 'CSE',  // Example stream
                'joining_year' => '2017',  // Example joining year
                'is_alumuni' => true,  // Example alumuni flag
                'user_id' => $user->id,  // Foreign key referencing the user
            ]);
        });
    }
}
