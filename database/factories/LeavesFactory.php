<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Leaves::class, function (Faker $faker) {
    return [
        'user_id' => function(){
        	return User::all()->random();
        },
        'date' => $faker->date,
        'adjusted_with' => function(){
            return User::all()->random();
        },
        'adjusted_on' => $faker->date,
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
        // 'date' => $faker->date,
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
