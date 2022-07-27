<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Month;
use App\User;
use Faker\Generator as Faker;


class MonthSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	// $faker = new Faker;
    	for($i=0;$i<99;$i++){
    		DB::table('month_subject')->insert([
        	// 'subject_id' => function(){
        	// 	return Subject::all()->random();
        	// },
        	'subject_id' => rand(21,37),
        	// 'month_id' => function(){
        	// 	return Month::all()->random();
        	// },
        	'month_id' => rand(1,12),
        	'lectures_planned' => rand(15,20),
        	'practicals_planned' => rand(2,4),
        	// 'created_by' => function(){
        	// 	return User::all()->random()->id;
        	// },
	        // 'updated_by' => function(){
	        // 	return User::all()->random()->id;
	        // },
	        // 'deleted_by' => function(){
	        // 	return User::all()->random()->id;
	        // }
	        'created_by' => rand(21,35)
        	]);
    	}
        
    }
}
