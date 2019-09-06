<?php

use Illuminate\Database\Seeder;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->insert(
            [
                ['name' => 'manage_general_settings'],
                ['name' => 'manage_users'],
                ['name' => 'manage_user_roles'],
                ['name' => 'manage_pages'],
                ['name' => 'manage_posts'],
                ['name' => 'manage_post_categories'],
                ['name' => 'manage_menus'],
                ['name' => 'manage_comments'],
                ['name' => 'see_admin_panel'],
            ]
        );
    }
}
