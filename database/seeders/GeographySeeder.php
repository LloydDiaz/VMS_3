<?php

namespace Database\Seeders;

use App\Models\Geography;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class GeographySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $jsonFilePath = database_path('data/geography.json');

        $jsonData = json_decode(file_get_contents($jsonFilePath), true);

        foreach ($jsonData as $item) {
            $item['timestamp'] = Carbon::createFromFormat('m/d/Y', $item['timestamp']);
            Geography::create($item);
        }
    }
}
