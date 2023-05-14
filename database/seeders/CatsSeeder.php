<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $remote = isset($_SERVER["REMOTE_ADDR"]) ?? false;
        $url = 'database/seeders/json/cats.json' ;
        
        $catsJson =  json_decode(file_get_contents($url,true));

        $cats = array_map(function ($cat) {
            return [
                'name'          =>  json_encode(['ar' => $cat->cat_name_ar , 'en' => $cat->cat_name_en ] , JSON_UNESCAPED_UNICODE),
                'id'    =>  $cat->id,
                'created_at'    => Carbon::now()->subMonth(rand(0,8)),
            ];
        }, $catsJson );
        
        DB::table('categories')->insert($cats) ;
    }
}
