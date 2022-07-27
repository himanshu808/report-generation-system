<?php

use Faker\Generator as Faker;
use App\Models\Lecture;
use App\Models\Topic;
use App\User;

$factory->define(App\Models\Topics_taken::class, function (Faker $faker) {
    return [
        'lecture_id' => function(){
        	return Lecture::all()->random();
        },
        'topic_id' => function(){
        	return Topic::all()->random();
        },
        'students_present' => $faker->numberBetween(0,80),
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
