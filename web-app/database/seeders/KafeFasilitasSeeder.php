<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KafeFasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('../engine/data_pipeline/output/kafe_fasilitas.sql');
        
        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);
        }
    }
}
