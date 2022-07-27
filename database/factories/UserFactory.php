<?php

use Faker\Generator as Faker;
use App\User;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $department = array("COMPS","IT","EXTC","ETRX");
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'department' => $department[array_rand($department,1)],
        'type' => $faker->numberBetween(1,3),
        'remember_token' => str_random(10),
        // 'created_by' => function(){
        // 	return User::all()->random();
        // },
        // 'updated_by' => function(){
        // 	return User::all()->random();
        // },
        // 'deleted_by' => function(){
        // 	return User::all()->random();
        // }
    ];
});
