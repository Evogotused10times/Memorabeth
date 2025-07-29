<?php
namespace Database\Seeders;

use App\Models\BurialRecord;
use Illuminate\Database\Seeder;

class BurialRecordSeeder extends Seeder
{
    public function run()
    {
        BurialRecord::create([
            'name' => 'Juan Dela Cruz',
            'plot_id' => 'A-101',
            'dates' => '1950-2020',
            'latitude' => 9.9519,
            'longitude' => 123.9654,
        ]);
        BurialRecord::create([
            'name' => 'Maria Santos',
            'plot_id' => 'B-202',
            'dates' => '1960-2023',
            'latitude' => 9.9520,
            'longitude' => 123.9655,
        ]);
    }
}