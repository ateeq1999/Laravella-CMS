<?php

use Illuminate\Database\Seeder;

class CPanelGeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            'website_name' => "Laravella CMS",
            'tagline' => "Build your project on Laravella CMS and take an advantage of it",
            'contact_email' => 'thehuseyn0w@gmail.com',
            'posts_per_page' => 10,
            'comments_per_page' => 5,
            'membership' => '1',
            'active_template_name' => 'default',
        ]);
    }
}
