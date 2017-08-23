<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($u) {
            $u->userMeta()->save(factory(App\UserMeta::class)->make());
            $u->address()->save(factory(App\Address::class)->make());

        });
    }
}
