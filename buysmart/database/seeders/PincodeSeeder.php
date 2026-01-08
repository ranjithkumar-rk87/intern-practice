<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pincode;
class PincodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pincodes = [
            ['pincode' => '626136', 'city' => 'R.Reddiapatti'],
            ['pincode' => '626117', 'city' => 'Rajapalayam'],
            ['pincode' => '626001', 'city' => 'Virudhunagar'],
        ];

        foreach ($pincodes as $pin) {
            Pincode::create($pin);
        }
    }
}
