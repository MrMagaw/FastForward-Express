<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < rand(5, 40); $i++) {
            $a = factory(App\Account::class)
            ->create([
                "user_id" => function(){
                    $uid = factory(App\User::class)->create()->user_id;

                    DB::table("user_roles")->insert([
                        "user_id" => $uid,
                        "role_id" => 3
                    ]);

                    return $uid;
                },
                "account_number" => $i,
                "stripe_id" => $i,
                "is_master" => true
            ]);
            
            for ($j = 0; $j < rand(1, 3); $j++) {
                $primary = false;
                if ($j == 0) $primary = true;

                DB::table("account_contacts")->insert([
                    "contact_id" => factory(App\Contact::class)->create()->contact_id,
                    "account_id" => $a->account_id,
                    "is_primary" => $primary
                ]);
            }

            if (rand(0, 10) < 9) continue;

            for ($k = 0; $k < rand(0, 5); $k++) {
                factory(App\Account::class)
                    ->create([
                        "user_id" => function(){
                            $uid = factory(App\User::class)->create()->user_id;

                            DB::table("user_roles")->insert([
                                "user_id" => $uid,
                                "role_id" => 3
                            ]);

                            return $uid;
                        },
                        "account_number" => $i . '-' . $k,
                        "stripe_id" => $i . '-' . $k,
                        "is_master" => false
                    ]);
            }
        }
    }
}
