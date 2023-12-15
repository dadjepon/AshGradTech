<?php

use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\Requirement;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed requirements for CS major
        $cs = Major::create(['name' => 'CS']);
        $this->createRequirements($cs, 2024, [1 => 4.5, 2 => 9, 3 => 13.5, 4 => 17.5, 5 => 22, 6 => 26, 7 => 30, 8 => 34]);
        $this->createRequirements($cs, 2025, [1 => 4, 2 => 8.5, 3 => 13, 4 => 17.5, 5 => 22.5, 6 => 27.5, 7 => 31.5, 8 => 35.5]);

        // Seed requirements for BA major
        $ba = Major::create(['name' => 'BA']);
        $this->createRequirements($ba, 2024, [1 => 4.5, 2 => 9, 3 => 13.5, 4 => 17.5, 5 => 21.5, 6 => 25.5, 7 => 29.5, 8 => 33.5]);
        $this->createRequirements($ba, 2025, [1 => 4.5, 2 => 9, 3 => 13.5, 4 => 17.5, 5 => 21.5, 6 => 25.5, 7 => 29.5, 8 => 33.5]);

        // Seed requirements for MIS major
        $mis = Major::create(['name' => 'MIS']);
        $this->createRequirements($mis, 2024, [1 => 4.5, 2 => 9, 3 => 13.5, 4 => 17.5, 5 => 21.5, 6 => 25, 7 => 29, 8 => 33]);
        $this->createRequirements($mis, 2025, [1 => 5, 2 => 9.5, 3 => 14, 4 => 18.5, 5 => 22, 6 => 25.5, 7 => 29.5, 8 => 33.5]);
    }

    private function createRequirements(Major $major, $year, array $requirements)
    {
        $major->requirements()->create([
            'year' => $year,
            'semester_1' => $requirements[1],
            'semester_2' => $requirements[2],
            'semester_3' => $requirements[3],
            'semester_4' => $requirements[4],
            'semester_5' => $requirements[5],
            'semester_6' => $requirements[6],
            'semester_7' => $requirements[7],
            'semester_8' => $requirements[8],
        ]);
    }
}


