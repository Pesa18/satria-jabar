<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SatriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat User
        $users = [];
        foreach (config('satria.users') as $userData) {
            $users[$userData['email']] = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );
        }

        // Buat Team
        foreach (config('satria.teams') as $key => $teamData) {
            $team = Team::updateOrCreate(
                ['slug' => $teamData['slug']],
                ['name' => $teamData['name']]
            );

            $superAdminUser = $users['superadmin@satria.com'] ?? null;
            if ($superAdminUser) {
                $team->members()->syncWithoutDetaching([$superAdminUser->id]);
            }
        };
    }
}
