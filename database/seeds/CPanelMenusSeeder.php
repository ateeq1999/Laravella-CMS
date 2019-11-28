<?php

use Illuminate\Database\Seeder;

class CPanelMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_content = [
            'en' => [
                ['slug' => '/', 'type' => 'pages', 'title' => 'Homepage'],
                ['slug' => 'contact', 'type' => 'pages', 'title' => 'Contact']
            ],
            'ru' => [
                ['slug' => '/', 'type' => 'pages', 'title' => 'Главная страница'],
                ['slug' => 'kontakti', 'type' => 'pages', 'title' => 'Контакты']
            ]
        ];

        DB::table('menus')->insert(
            ['slug'   => 'header_menu']
        );

        DB::table('menu_translations')->insert([
            [
                'title' => 'Header Menu',
                'locale' => 'en',
                'menu_id' => 1,
                'content' => json_encode($menu_content['en'])
            ],
            [
                'title' => 'Меню в шапке',
                'locale' => 'ru',
                'menu_id' => 1,
                'content' => json_encode($menu_content['ru'])
            ]
        ]);
    }
}
