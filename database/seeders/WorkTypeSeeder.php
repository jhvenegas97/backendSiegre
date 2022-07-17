<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/data/tipos-trabajo.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                WorkType::create([
                    "name_work_type" => $data['0']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
