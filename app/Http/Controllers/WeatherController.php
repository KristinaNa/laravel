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
        return view('main');

//        $results = DB::select('select town from towns');
        // pass your $builds to your view
        //return View::make('pages/home')->with('builds', $builds);

  //      return View::make('main', array('array' => $results));


    }

    public function store(){
        $city = Request::input('town');
        $response = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=f84ba1064b0ae65792326548686f361c'), true);
        //print_r($response);
        $id = $response['id'];
        $name = $response['name'];

        $temp_min = $response['main']['temp_min'];
        $temp_max = $response['main']['temp_max'];
        $temp_min = round($temp_min - 273.15);
        $temp_max = round($temp_max - 273.15);
        $date = date("Y-m-d H:i:s", $response['dt']);

        $weather = new Weather;
        $weather->town = $name;
        $weather->temp_min = $temp_min;
        $weather->temp_max = $temp_max;
        $weather->date = $date;
        $weather->save();

        $town = new Town;
        $town->town = $name;
        $town->save();
        return redirect()->action('WeatherController@index');

    }




}