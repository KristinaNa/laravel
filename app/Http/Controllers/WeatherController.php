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
use Carbon\Carbon;




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
        $town_id = DB::table('towns')->where('town', $town)->first();
        $town_id = $town_id->id;      //получить id города

        $date_today = (date("Y-m-d", strtotime("+0 day")));
        $dates_array = DB::table('weather')
            ->where('town_id', $town_id)
            ->where('kuupaev','>=', $date_today)
            ->select(DB::raw('DATE(kuupaev) as date'))
            ->groupBy('date')
            ->get();
        $dates_array = json_decode(json_encode((array) $dates_array), true);
        if(count($dates_array)>0){
            foreach($dates_array as $i){
                $array = DB::table('weather')
                    ->where('town_id', $town_id)
                    ->whereBetween('kuupaev', [$i['date'].' 00:00:00', $i['date'].' 23:59:59'])
                    ->get();
                $array = json_decode(json_encode((array) $array), true);
                $data[] = $array;
            }
            //   print_r($data);
            return View::make('weather', array('town' => $town, 'data' => $data));
        }else{
            return View::make('no_weather',array('town' => $town));
        }

    }

    public function refresh($town) {
        $town_id = DB::table('towns')->where('town', $town)->first();
        $town_id = $town_id->id;      //получить id города
        $response = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q='.$town.'&mode=json&appid=f84ba1064b0ae65792326548686f361c'), true);
       //  print_r($response);
        $id = $response['city']['id'];
        $date_today = (date("Y-m-d", strtotime("+0 day")));

        DB::table('weather')->where('kuupaev', '>=', $date_today)->where('town_id', $town_id)->delete();

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
        return redirect('weather/'.$town);
    }
}