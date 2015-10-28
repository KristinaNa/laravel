<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Weather;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Validator;
use View;



class WeatherController extends Controller {
    public function index(){
        return view('main');
    }
    public function store(Request $request){
        $city = $request->input('town');
        $response = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q='.$city.'&mode=json&appid=f84ba1064b0ae65792326548686f361c'), true);
      //  print_r($response);
        $id = $response['city']['id'];
        $name = $response['city']['name'];
        $validator = Validator::make($request->all(), [
            'town' => 'required|unique:towns,town'
        ]);

        if ($validator->fails()) {
            return redirect('')
                ->withErrors($validator)
                ->withInput();
        }
        $town = new Town;
        $town->town = $name;
        $town->id = $id;
        $town->save();
        for($i = 0; $i < sizeof($response['list']); $i++){
            $date=date("Y-m-d H:i:s",$response['list'][$i]['dt']);
            $temp_min=$response['list'][$i]['main']['temp_min'];
            $temp_max=$response['list'][$i]['main']['temp_max'];
            $temp_min = round($temp_min - 273.15);
            $temp_max = round($temp_max - 273.15);

            $weather = new Weather;
            $weather->town_id = $id;
            $weather->temp_min = $temp_min;
            $weather->temp_max = $temp_max;
            $weather->kuupaev = $date;
            $weather->save();

        }
        return redirect()->action('WeatherController@index');
    }

    public function show($town) {
       return View::make('weather', array('town' => $town));
    }


}