<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name' => "Elman",
                    'surname' => "Hüseynov",
                    'email' => "thehuseyn0w@gmail.com",
                    'username' => "huseyn0w",
                    'city' => "Baku",
                    'country' => "AZ",
                    'role_id' => "1",
                    'about_me' => "Founder of CMS Laravella",
                    'linkedin_url' => "https://linkedin.com/in/huseyn0w",
                    'password' => bcrypt('elman123'),
                ],
                [
                    'name' => "Ilkin",
                    'surname' => "Alibeyli",
                    'email' => "ilkinalibeyli@gmail.com",
                    'username' => "ilkin007",
                    'city' => "Berlin",
                    'country' => "DE",
                    'role_id' => "1",
                    'about_me' => "Contributor of CMS Laravella",
                    'linkedin_url' => "https://www.linkedin.com/in/ilkin-alibayli/",
                    'password' => bcrypt('ilkin123'),
                ]
            ]
        );
    }
}