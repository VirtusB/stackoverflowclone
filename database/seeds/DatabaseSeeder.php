<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 3)->create()->each(function (App\User $user) { // create 3 users
            $user->questions()->saveMany(
                factory(App\Question::class, random_int(1, 5))->make() // create between 1 and 5 questions for every user
            )
            ->each(function ($q) {
                $q->answers()->saveMany(factory(App\Answer::class, random_int(1, 5))->make()); // create between 1 and 5 answers for every question
            });
        });
    }
}
