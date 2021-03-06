<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\RentResource;
use App\Resource;

class RentResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = date('Y-m-d H:i:s');

        DB::table('rent_resources')->insert([
		'user_id' => 5,
		'resource_id' => 1,
		'start_time' => $now,
		'end_time' => $now,
		'status' => 'In use'
		]);

        // pick dates for start_time and end time like this
        // 
		// $date = new Carbon('first day of December 2008')
		// $date = Carbon::parse('1975-05-21 22:23:00.123456');

		DB::table('rent_resources')->insert([
		'user_id' => 6,
		'resource_id' => 2,
		'start_time' => $now,
		'end_time' => $now,
		'status' => 'In use'
		]);

		$resources = Resource::all();

		$maxUsers = DB::table('users')->max('id');
		$maxResources = DB::table('resources')->max('id');

		foreach ($resources as $resource) {
			$number = rand(23, 40);
			
			for ($i = 0; $i < $number; $i++){

				$start_offset = rand(-3,12);
				$now = Carbon::now();
				
				$start = $now->copy();
				$start->addDays(rand(-7,7));
				$start->addMinutes(rand(12,40));
				$start->addHours($start_offset);
				
				$end = $start->copy();
				$end->addMinutes(rand(0,60));


				DB::table('rent_resources')->insert([
				'user_id' => rand(1, $maxUsers),
				'resource_id' => rand(1, $maxResources),
				'start_time' => $start,
				'end_time' => $end,
				'status' => 'In use'
				]);
			}
		}



    }
}
