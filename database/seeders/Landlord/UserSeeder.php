<?php

namespace Database\Seeders\Landlord;

use App\Models\Landlord\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'uuid' => Uuid::uuid4(),
            'email' => 'o.olayinka@digikraaft.ng',
            'password' => Hash::make('password'),
            'name' => 'olumayokun olayinka'
        ]);
    }
}
