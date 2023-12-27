<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'user_name' => 'admin',
            'email' => 'duc12@gmail.com',
            'password' => bcrypt('password'),
            'address' => '123 Admin St',
            'phone_number' => '1234567890',
        ]);

        $permissions = Permission::whereIn('name', ['add', 'edit', 'delete'])->get();
        $role = Role::where('name', 'admin')->first();

        if ($role) {
            $user->roles()->attach($role->id);
            foreach ($permissions as $permission) {
                if (!$role->permissions()->find($permission->id)) {
                    $role->permissions()->attach($permission);
                }
            }
        }
    }
}

