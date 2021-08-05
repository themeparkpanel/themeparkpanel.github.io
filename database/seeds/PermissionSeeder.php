<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::select('name')->get();
        $array = [
            'roles_see', 'roles_edit',
            'status_see', 'status_edit',
            'project_see', 'project_edit',
            'user_see', 'user_edit',
            'order_see', 'order_edit'
        ];

        foreach($array as $name) {
            if($permissions->contains('name', $name))
                continue;

            Permission::create([
                'name' => $name
            ]);
        }

        $role = Role::create([
            'name' => 'administrator',
            'readable_name' => 'Administrator',
            'color' => '#e74c3c',
            'index' => 1
        ]);

        $role->syncPermissions($array);
    }
}
