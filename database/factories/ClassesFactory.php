<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Classes::class, function (Faker $faker) {
	$department = array("COMPS","IT","EXTC-A","EXTC-B","ETRX");
	$year = array("SE","TE","BE");
    return [
        'department' => $department[array_rand($department,1)],
        'year' => $year[array_rand($year,1)],
        'strength' => $faker->numberBetween(60,80),
        'batch' => $faker->year,
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
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
