<?php

namespace Database\Seeders;

use App\Models\Experiment;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class ExperimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $experiment_file = file_get_contents(__DIR__.'/experiment.json');
        $experiment_json = json_decode($experiment_file);
        if($experiment_json) {
            foreach ($experiment_json as $experiment) {
                $permission = Experiment::create([
                    'name'          => $experiment->name,
                    'type'          => $experiment->type
                ]);
            }
        }
    }
}
