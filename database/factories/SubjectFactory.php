<?php

use Faker\Generator as Faker;
use App\User;
use App\Models\Classes;

$factory->define(App\Models\Subject::class, function (Faker $faker) {
    return [
        'user_id' => function(){
        	return User::all()->random();
        },

        // 'user_id' => function(){
        //     return User::find(rand(21,35));
        // },
        'classes_id' => function(){
        	return Classes::all()->random();
        },
        'course_code' => $faker->word,
        'name' => $faker->word,
        'total_hours' => $faker->numberBetween(6,12),
        'total_practicals' => $faker->numberBetween(7,12),
        'total_tutorials' => $faker->numberBetween(2,8),
        'total_assignments' => $faker->numberBetween(1,2),
        'created_by' => function(){
        	return User::all()->random();
        },
        'updated_by' => function(){
        	return User::all()->random();
        },
        'deleted_by' => function(){
        	return User::all()->random();
        }

        // 'created_by' => function(){
        //     return  User::find(rand(21,35));
        // },
        // 'updated_by' => function(){
        //     return  User::find(rand(21,35));
        // },
        // 'deleted_by' => function(){
        //     return  User::find(rand(21,35));
        // }
    ];
});
