<?php

use Faker\Generator as Faker;
use App\User;
use App\Models\Subject;

$factory->define(App\Models\Lecture::class, function (Faker $faker) {
    return [
        'user_id' => function(){
        	return User::all()->random();
        },
        'subject_id' => function(){
            return Subject::all()->random();
        },
        'type' => $faker->numberBetween(1,4),
        'isAdjusted' => $faker->boolean(50),
        'timeslot' => $faker->time,
        'created_by' => function(){
        	return User::all()->random();
        },
        'updated_by' => function(){
        	return User::all()->random();
        },
        'deleted_by' => function(){
        	return User::all()->random();
        }

        // 'user_id' => function(){
        //     return User::find(rand(21,35));
        // },
        // 'created_by' => function(){
        //     return User::find(rand(21,35));
        // },
        // 'updated_by' => function(){
        //     return User::find(rand(21,35));
        // },
        // 'deleted_by' => function(){
        //     return User::find(rand(21,35));
        // }
    ];	
});
