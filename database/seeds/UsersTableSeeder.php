<?php

use Illuminate\Database\Seeder;
use App\Http\Models\User;

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
                    'country' => "Azerbaijan",
                    'role_id' => 1,
                    'gender'  => "male",
                    'avatar'  => env('APP_URL').'/filemanager/images/5dbb536d16ce8.jpg',
                    'about_me' => "Founder of CMS Laravella",
                    'linkedin_url' => "https://linkedin.com/in/huseyn0w",
                    'password' => bcrypt('elman123'),
                ],
                [
                    'name' => "Admin",
                    'surname' => "",
                    'email' => "admin@ehuseynov.com",
                    'username' => "admin",
                    'city' => "",
                    'country' => "",
                    'role_id' => 1,
                    'gender'  => "male",
                    'avatar'  => '',
                    'about_me' => "ADMIN of CMS Laravella",
                    'linkedin_url' => "",
                    'password' => bcrypt('laravelladmin123'),
                ],
                [
                    'name' => "Ilkin",
                    'surname' => "Alibayli",
                    'email' => "ilkinalibeyli@gmail.com",
                    'username' => "ilkin007",
                    'city' => "Berlin",
                    'country' => "Germany",
                    'role_id' => 1,
                    'gender'  => "male",
                    'about_me' => "Contributor of CMS Laravella",
                    'avatar'  => env('APP_URL').'/filemanager/images/5db367b4093af.jpg',
                    'linkedin_url' => "https://www.linkedin.com/in/ilkin-alibayli/",
                    'password' => bcrypt('ilkin123'),
                ]
            ]
        );

        factory(User::class, 30)->create();
    }
}
