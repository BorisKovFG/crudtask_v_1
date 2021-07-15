<?php

namespace App;

class Generator
{
    public static function generate($count = 100)
    {
        $numbers = range(1, $count);
        shuffle($numbers);

        $faker = \Faker\Factory::create();
        $faker->seed(1);
        $posts = [];
        for ($i = 0; $i < $count; $i++) {
            $posts[] = [
                'id' => $faker->uuid,
                'name' => $faker->firstName,
                'body' => $faker->company,
                'phone' => $faker->phoneNumber
            ];
        }

        return $posts;
    }
}

