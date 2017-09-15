<?php

use Illuminate\Database\Seeder;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Business::class, 1000)->create()->each(function($u) {
            $u->file()->save(factory(App\File::class)->make());
            $u->address()->save(factory(App\Address::class)->make());
        });
    }
}
