<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
//        Question::truncate();
        Schema::enableForeignKeyConstraints();
        User::create([
            'login' => 'test',

            'email' => 'test@gmail.com',
            'password' => bcrypt('test'),

            'name' => 'Test',
            'lastname' => 'Testovich',

            'avatar' => 'assets/app/media/img/users/300_12.jpg',

            'active' => true,
        ]);
    }
}
