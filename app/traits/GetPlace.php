<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
trait GetPlace
{


    public  function loaction($model,$latitude,$longitude , $attachmentRelation = 'attachmentRelation' , $type = null)
    {



        $location          =       $model ;

        $location          =       $location->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"));
        $location          =       $location->having('distance', '<', 20);
        $location          =       $location->orderBy('distance', 'asc');

        $location          =       $location->where(function ($q) use ($type){
            $q->where('type',$type);
        })->get()->load('attachmentRelation');


        return $location ;
    }
    
     public  function loactions($request,$model,$latitude,$longitude , $attachmentRelation = 'attachmentRelation' , $type = null)
    {



        $location          =$model->where('last_activity', '>=', Carbon::now()->subMinutes('5')->format('Y-m-d H:i:s'))->where('type_id',$request->type_id);
 ;

        $location          =       $location->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"));
        $location          =       $location->having('distance', '<', 20);
        $location          =       $location->orderBy('distance', 'asc');

        $location          =       $location->where(function ($q) use ($type){
            $q->where('type',$type);
        })->get()->load('attachmentRelation');


        return $location ;
    }
}

