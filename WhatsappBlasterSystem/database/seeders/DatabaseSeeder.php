<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OnsendApi;
use App\Models\Blaster;
use App\Models\Customer;
use App\Models\Message;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //default user
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'SuperAdmin@gmail.com',
            'role' => 1,
            'phone' => '60123456789',
            'password' => Hash::make('super1234'),
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'role' => 0,
            'phone' => '60123456789',
            'password' => Hash::make('user1234'),
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'role' => 0,
            'phone' => '60123456789',
            'password' => Hash::make('user21234'),
        ]);
        //default onsend api
        OnsendApi::create([
            'user_id' => '2',
            'api' => 'd5bd09371f31fd7c8efa78d1732d24f9e3f96a8643dd05f6075dedcd19c05452',
        ]);

        //default blaster
        Blaster::create([
            'user_id' => '2',
            'name' => 'Test1',
            'image' => 'test.png',
        ]);
        Blaster::create([
            'user_id' => '2',
            'name' => 'Test2',
            'image' => 'test.png',
        ]);

        //default customer
        Customer::create([
            'blaster_id' => '1',
            'attribute1' => 'jj1',
            'attribute2' => '0143886279',
            'attribute3' => 'address1',
            'attribute4' => '19-7-2023',
            'attribute5' => null,
            'attribute6' => null,
            'attribute7' => null,
        ]);
        Customer::create([
            'blaster_id' => '1',
            'attribute1' => 'jj2',
            'attribute2' => '0143886279',
            'attribute3' => 'address2',
            'attribute4' => '09-10-2023',
            'attribute5' => null,
            'attribute6' => null,
            'attribute7' => null,
        ]);
        Customer::create([
            'blaster_id' => '1',
            'attribute1' => 'jj3',
            'attribute2' => '0169682362',
            'attribute3' => 'address3',
            'attribute4' => '15-5-2023',
            'attribute5' => null,
            'attribute6' => null,
            'attribute7' => null,
        ]);

        //default message
        Message::create([
            'user_id' => '2',
            'message' => 'Hi,[attribute1], your adrress is [attribute3], you road tax will be expire at [attribute4].',
            'blaster_id' => '1',
            'send_time' => '2023-04-5 12:09:00',
            'phone' => '[attribute2]'
        ]);
    }
}
