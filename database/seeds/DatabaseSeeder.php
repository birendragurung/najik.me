<?php

use App\Address;
use App\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        //https://laravel-news.com/learn-to-use-model-factories-in-laravel-5-1
        //{*
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(UserMetaTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(BusinessTableSeeder::class);
        Model::reguard();
        //*}
    }
}
