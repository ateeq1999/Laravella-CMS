<?php

use Illuminate\Database\Seeder;
use App\Http\Models\UserPermissions as UserPermissions;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(UserPermissions $permissions)
    {
        $user_permissions = $permissions->all();

        $admin_permissions_array = [];
        $user_permissions_array = [];

        foreach($user_permissions as $permission){
            $admin_permissions_array[$permission['name']] = 1;
            $user_permissions_array[$permission['name']] = 0;
        }

        $user_permissions_json = json_encode($user_permissions_array);
        $admin_permissions_json = json_encode($admin_permissions_array);

        DB::table('user_roles')->insert(
            [
                ['name' => 'Administrator', 'permissions' => $admin_permissions_json],
                ['name' => 'User', 'permissions' => $user_permissions_json],
            ]
        );
    }
}
