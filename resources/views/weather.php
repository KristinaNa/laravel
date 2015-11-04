<html>
    <head>
        <title>Weather</title>
        <style>
            #table{overflow-x: scroll}
        </style>
    </head>
    <body>

    
<?php
    $town_id = DB::table('towns')->where('town', $town)->first();
    $town_id = $town_id->id;      //получить id города

    $date_today = (date("Y-m-d", strtotime("+0 day")));
    $date_tomorrow = (date("Y-m-d", strtotime("+1 day")));
    $date_after_tomorrow = (date("Y-m-d", strtotime("+2 day")));


    $weather_today = DB::table('weather')
        ->where('town_id', $town_id)
        ->whereBetween('kuupaev', [$date_today, $date_today.' 23:59:59'])
        ->get();
    $weather_tomorrow = DB::table('weather')
        ->where('town_id', $town_id)
        ->whereBetween('kuupaev', [$date_tomorrow, $date_tomorrow.' 23:59:59'])
        ->get();
    $weather_after_tomorrow = DB::table('weather')
        ->where('town_id', $town_id)
        ->whereBetween('kuupaev', [$date_after_tomorrow, $date_after_tomorrow.' 23:59:59'])
        ->get();


    $weather_today = json_decode(json_encode((array) $weather_today), true);
    $weather_tomorrow = json_decode(json_encode((array) $weather_tomorrow), true);
    $weather_after_tomorrow = json_decode(json_encode((array) $weather_after_tomorrow), true);


    $array = array(
        $date_today => $weather_today,
        $date_tomorrow => $weather_tomorrow,
        $date_after_tomorrow => $weather_after_tomorrow
    );

    // print_r($array);

    echo "<table border='1'><tr>";
    foreach ($array as $key => $avalue) {
        echo "<td>" . date("d. F",strtotime($key)) . "</td>";
        for ($i = 0; $i < count($avalue) - 1; $i++)
            echo '<td>' . date("H:i",strtotime($avalue[$i]['kuupaev'])) . '<br/>Min: ' . $avalue[$i]['temp_min'] . '<br/>Max: ' . $avalue[$i]['temp_max'] . '</td><br /></td></tr>';
    }
    echo "</tr></table>";














   /* $d = (date("Y-m-d", strtotime("+0 day")));
    $date_today = $d." 00:00:00";
    DB::table('weather')->where('kuupaev','<', $date_today)->delete(); //удалить старые данные
    $town_id = DB::table('towns')->where('town', $town)->first();
    $town_id = $town_id->id;                                        //получить id города


    echo "<div id = 'table'><table border = '1'><tr><td>";
    $weather_today = DB::table('weather')
        ->where('town_id', $town_id)
        ->whereBetween('kuupaev',array($d, $d.' 23:59:59'))
        ->get();
    $weather_today = (array)$weather_today; // stdObject class ---> Array
    foreach($weather_today as $w){
        $array = (array)$w;    // stdObject class ---> Array
        $temp_min = $array['temp_min'];
        $temp_max = $array['temp_max'];
        $date = $array['kuupaev'];
        echo "Date: ".$date."<br> Min:".$temp_min."<br> Max: ".$temp_max."<br><p>";
    }
    echo "</td><td>";


    $date_tomorrow = (date("Y-m-d", strtotime("+1 day")));
    $weather_tomorrow = DB::table('weather')
        ->where('town_id', $town_id)
        ->whereBetween('kuupaev',array($date_tomorrow, $date_tomorrow.' 23:59:59'))
        ->get();
    $weather_tomorrow = (array)$weather_tomorrow;
    foreach($weather_tomorrow as $w){
        $array = (array)$w;    // stdObject class ---> Array
        $temp_min = $array['temp_min'];
        $temp_max = $array['temp_max'];
        $date = $array['kuupaev'];
        echo "Date: ".$date."<br> Min:".$temp_min."<br> Max: ".$temp_max."<br><p>";
    }
    echo "</td>";


    echo "</td></tr></table></div>";

*/
    ?>



    </body>
</html>
