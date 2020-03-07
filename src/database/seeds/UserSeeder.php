<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 50)->states("enough_salary")->create()
            ->each(function (\App\Models\User $user) {

                if ($this->faker->boolean){
                    $user->accounts()->save(factory(\App\Models\Account::class)->make());
                }
            });
    }
}
