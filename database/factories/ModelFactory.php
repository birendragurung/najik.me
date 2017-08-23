<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\User::class , function(Faker\Generator $faker)
{
    static $password;

    return ['name'           => $faker->name ,
            'email'          => $faker->unique()->safeEmail ,
            'password'       => $password ? : $password = bcrypt('secret') ,
            'remember_token' => str_random(10) ,
            'username'       => $faker->unique()->userName ,
            'first_name'     => $faker->firstName ,
            'middle_name'    => $faker->word ,
            'last_name'      => $faker->lastName ,
            'date_of_birth'  => $faker->date() ,
            'verified_at'    => $faker->dateTime() ,
            'verified'       => $faker->randomElement(['yes' , 'no' , 'pending'])];
});
$factory->define(App\UserMeta::class , function(Faker\Generator $faker)
{
    return ['role' => $faker->randomElement(['admin' , 'moderator' , 'business_owner' , 'user'])];
});
$factory->define(App\Address::class , function(Faker\Generator $faker)
{
    return ['address'     => $faker->streetAddress ,
            'town'        => $faker->randomElement(['Butwal' ,'Dharan' ,'Palpa' ,'Kathmandu' ,'Biratnagar' ,'Pokhara' ,'Itahari' ,'Bhaktapur']) ,
            'state'       => $faker->randomElement(['Lumbini' , 'Arizona' , 'California']) ,
            'country'     => 'Nepal' ,
            'zip_code'    => $faker->postcode ,
            'latitude'    => $faker->latitude ,
            'longitude'   => $faker->longitude ,
    ];
});
$factory->define(App\File::class , function(Faker\Generator $faker)
{
    return ['filename'  => $faker->file('/user/') ,
            'meta_name' => $faker->randomElement(['citizenship_document' , 'driver_license' ])
    ];
});
$factory->define(App\Business::class , function(Faker\Generator $faker)
{
    return [
        'user_id'=>1,
        'name' => $faker->name,
        'description' => $faker->paragraph(5) ,
        'open_from'=> '10:00',
        'open_upto'=> '18:00',
        'phone_number' => $faker->phoneNumber,
        'mobile_number' => $faker->phoneNumber ,
        'email' => $faker->safeEmail ,
        'website' =>$faker->randomElement(['https://', 'http://']) . 'www.' .  $faker->word . "." . $faker->randomElement(['com','net','edu','org'])  ,

    ];
});