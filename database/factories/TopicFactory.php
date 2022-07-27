<?php

use Faker\Generator as Faker;
use App\Models\Subject;
use App\User;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    return [
      	'subject_id' => function(){
      		return Subject::all()->random();
      	} ,
      	'name' => $faker->sentence(),
      	'due_date' => $faker->date,
      	'type' => $faker->numberBetween(1,4),
      	'state' => $faker->boolean(50),
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
        //   return User::find(rand(21,35));
        // },
        // 'updated_by' => function(){
        //   return User::find(rand(21,35));
        // },
        // 'deleted_by' => function(){
        //   return User::find(rand(21,35));
        // }
    ];
});
