<?php

namespace Database\Seeders;

use App\Models\Land;
use App\Models\User;
use App\Models\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //create user
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'farmer',
            'email' => 'farmer@mail.com',
            'password' => bcrypt('password'),
            'role' => 'farmer',
        ]);

        //create one lands
        $land = Land::create([
            // 11011711010711911100014012
            'user_id' => 2,
            'name' => 'Padi Berkualitas',
            'description' => 'Padi import berkualitas',
            'polygon' => '-6.4095639936874145 108.26466406165014,-6.409929159292516 108.26465869723211,-6.4099398210580745 108.26502615986715,-6.409555997357362 108.26499129114995,',
            'area' => '50',
            'crop_planted_at' => '2020-04-01',
        ]);

        // add device to land
        $land->devices()->create([
            'id' => '11011711010711911100014012',
            'name' => 'Device 1',
        ]);

        //add sensor name
        $sensors = [
            ['sensor' => 'PH AIR'],
            ['sensor' => 'PH TANAH'],
            ['sensor' => 'SOIL MOISTURE'],
            ['sensor' => 'LIGHT'],
            ['sensor' => 'TEMPERATUR UDARA'],
            ['sensor' => 'KELEMBAPAN UDARA'],
            ['sensor' => 'WINDSPEED'],
            ['sensor' => 'RAINFALL'],
        ];

        $status = 'Belum di Kalibrasi';

        foreach ($sensors as $sensor){
            $sensor['status'] = $status;

            Sensor::create($sensor);
        }

        // Sensor::find(1)->kalibrasi()->create([
        //     'data_sensor' =>50,
        //     'data_alat_ukur' => 50,
        // ]);
    }
}
