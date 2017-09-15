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
    return [
        'street_address'     => $faker->streetAddress ,
            'town'        => $faker->randomElement(['Butwal' ,'Dharan' ,'Palpa' ,'Kathmandu' ,'Biratnagar' ,'Pokhara' ,'Itahari' ,'Bhaktapur']) ,
            'state'       => $faker->randomElement(['Lumbini' , 'Arizona' , 'California']) ,
            'country'     => 'Nepal' ,
            'zip_code'    => $faker->postcode ,
            'latitude'    => $faker->randomFloat(6,27 , 27.6) ,
            'longitude'   => $faker->randomFloat(6,83 , 83.6) ,
    ];
});
$factory->define(App\File::class , function(Faker\Generator $faker)
{
    return ['filename'  => '1503480082599d4912e8d191.44049730'  ,
            'file_extension' =>'jpg',
            'file_title' => 'business profile pic' ,
            'description' => $faker->text() ,
            'file_url' => '/business/uploads/1503480082599d4912e8d191.44049730.jpg' ,
            'mime_type' => 'image/jpeg' ,
            'absolute_path' => 'C:\xampp\htdocs\najik.me\storage/app/public/uploads/business/1503480082599d4912e8d191.44049730.jpg' ,
            'parent_dir_path' => 'C:\xampp\htdocs\najik.me\storage\app/uploads/business/' ,


            'meta_name' => $faker->randomElement(['business_profile_pic' ,])];
});
$factory->define(App\Business::class , function(Faker\Generator $faker)
{
    return [
        'user_id'=>$faker->numberBetween(2105,2540) ,
        'name' => $faker->name,
        'description' => $faker->paragraph(5) ,
        'open_from'=> '10:00',
        'open_upto'=> '18:00',
        'phone_number' => $faker->phoneNumber,
        'mobile_number' => $faker->phoneNumber ,
        'email' => $faker->safeEmail ,
        'website' =>$faker->randomElement(['https://', 'http://']) . 'www.' .  $faker->word . "." . $faker->randomElement(['com','net','edu','org'])  ,
        'category_id' => $faker->numberBetween(1 , 12) ,
        'verified' =>$faker->randomElement(['yes','no','pending'])
    ];
});