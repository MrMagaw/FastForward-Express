<?php

use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $stripe_ids = array(
            "cus_8ynZkXhBHTXkux",
            "cus_8zAePKdfiC1QMW",
            "cus_8zAe2sRM0d1jC6",
            "cus_8zAepil5YN3cXY"
        );

        $driver_numbers = array(
            "0000001",
            "0000002",
            "0000003",
            "0000004",
        );

        for($i = 0; $i < 4; $i++) {
            $d = factory(App\Driver::class)->create([
                "contact_id" => factory(App\Contact::class)->create()->contact_id,
                "user_id" => function(){
                    $uid = factory(App\User::class)->create()->user_id;

                    DB::table('user_roles')->insert([
                        "user_id" => $uid,
                        "role_id" => 2
                    ]);

                    return $uid;
                },
                "driver_number" => $driver_numbers[$i],
                "stripe_id" => $stripe_ids[$i],
            ]);

            //Add expiries
            $eid = DB::table('driver_expiries')->insertGetId([
                'driver_id' => $d->driver_id,
                'expiry_id' => 2
            ]);

            DB::table('expiry_modifications')->insert([
                'modification_id' => factory(App\Modification::class)->create([
                    "comment" => "Expiry added"
                ])->modification_id,
                'driver_expiry_id' => $eid
            ]);

            if (rand(0, 1) == 1) {
                $eid = DB::table('driver_expiries')->insertGetId([
                    'driver_id' => $d->driver_id,
                    'expiry_id' => 1
                ]);

                DB::table('expiry_modifications')->insert([
                    'modification_id' => factory(App\Modification::class)->create([
                        "comment" => "Expiry added"
                    ])->modification_id,
                    'driver_expiry_id' => $eid
                ]);
            }

            //Add chargebacks
            $cbid = DB::table('driver_chargebacks')->insertGetId([
                "chargeback_id" => 1,
                "driver_id" => $d->driver_id,
                "charge_date" => $faker->dateTimeThisMonth,
                'amount' => rand(1000, 50000) / 100
            ]);

            DB::table('chargeback_modifications')->insert([
                "modification_id" => factory(App\Modification::class)->create([
                    "comment" => "Chargeback added"
                ])->modification_id,
                "driver_chargeback_id" => $cbid
            ]);

            if (rand(0,4) == 1){
                $cbid = DB::table('driver_chargebacks')->insertGetId([
                    "chargeback_id" => 2,
                    "driver_id" => $d->driver_id,
                    "charge_date" => $faker->dateTimeThisMonth,
                    'amount' => rand(1000, 50000) / 100
                ]);

                DB::table('chargeback_modifications')->insert([
                    "modification_id" => factory(App\Modification::class)->create([
                        "comment" => "Chargeback added"
                    ])->modification_id,
                    "driver_chargeback_id" => $cbid
                ]);
            }

            if (rand(0,1) == 1){
                $cbid = DB::table('driver_chargebacks')->insertGetId([
                    "chargeback_id" => 3,
                    "driver_id" => $d->driver_id,
                    "charge_date" => $faker->dateTimeThisMonth,
                    'amount' => rand(1000, 50000) / 100
                ]);

                DB::table('chargeback_modifications')->insert([
                    "modification_id" => factory(App\Modification::class)->create([
                        "comment" => "Chargeback added"
                    ])->modification_id,
                    "driver_chargeback_id" => $cbid
                ]);
            }
        }
    }
}
