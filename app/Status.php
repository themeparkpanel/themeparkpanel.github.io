<?php
namespace App;

use Illuminate\Support\Facades\DB;

class Status {

    private static $data = null;
    public static function loadData() {
        if(self::$data !== null)
            return self::$data;

        $regions = DB::table('regions')->get()->all();
        $attractions = DB::table('attractions')->get()->all();
        $statuses = DB::table('states')->get()->all();

        $data = [];
        foreach($regions as $region) {
            $region->attractions = [];
            $data[$region->id] = $region;
        }

        $status = [];
        foreach ($statuses as $stat)
            $status[$stat->id] = (object) [
                "name" => $stat->name,
                "color" => $stat->color,
            ];

        foreach ($attractions as $attraction) {
            $region_id = $attraction->region_id;
            $attraction->status = $status[$attraction->status_id];
            if(array_key_exists($region_id, $data))
                array_push($data[$region_id]->attractions, $attraction);
        }

        $temp = $data;
        $data = [];
        foreach ($temp as $key => $value)
            if(!empty($value->attractions))
                array_push($data, $value);

        self::$data = $data;
        return $data;
    }

}
