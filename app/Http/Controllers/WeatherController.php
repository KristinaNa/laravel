<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Weather;
use Illuminate\Support\Facades\Redirect;
use Request;
use App\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class WeatherController extends Controller {
    public function index(){
        //return view('main');



    }

    public function store(){
        $city = Request::input('town');
        $response = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q='.$city.'&mode=json'), true);
        //print_r($response);
        $id = $response['city']['id'];
        $name = $response['city']['name'];
        $info = $response['list'];
        //  print_r($info);
        $length = count($info);
        for ($i = 0; $i < $length; $i++) {
            $date = date("Y-m-d H:i:s", $info[$i]['dt']);
            $temp_min = $info[$i]['main']['temp_min'];
            $temp_max = $info[$i]['main']['temp_max'];
            $temp_min = round($temp_min - 273.15);
            $temp_max = round($temp_max - 273.15);

            $weather = new Weather;
            $weather->town = $name;
            $weather->temp_min = $temp_min;
            $weather->temp_max = $temp_max;
            $weather->date = $date;
            $weather->save();
        }
        $town = new Town;
        $town->town = $name;
        $town->save();
        return redirect()->action('WeatherController@index');
    }


}