<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Dashboard;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where([
            'email' => 'admin@admin.com',
        ])->first();

        if ($admin) {
            $admin->delete();
        }

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'permissions' => Dashboard::getAllowAllPermission(),
            'password' => Hash::make('123')
        ]);
    }
}
