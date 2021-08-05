<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $user = User::create([
            'firstname' => 'Admin',
            'surname' => '',
            'email' => 'admin@localhost',
            'password' => Hash::make('admin'),
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'email_verified_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        $user->assignRole('administrator');
    }
}
