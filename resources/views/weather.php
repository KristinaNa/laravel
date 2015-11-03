<html>
    <head>
        <title>Weather</title>
        <style>
            #table{overflow-x: scroll}
        </style>
    </head>
    <body>



    <?php
 /*  1. Запросы на погоду, переносишь в метод show и передаёшь их из контроллера в вью.
    2. На тему красоты есть варианты следующие.

    Делаем ассоциативный массив, напимер weather
    Где ключ будет дата, например 21 ноября а значение будет обьект из базы

    В этот массив записываем результаты погоды за сегодня

    За сегодня
    За завтра
    За после завтра

    (Это тоже можно сделать в виде цикла но пока не заморачивайся и напиши отдельно по строчке на сегодня, завтра, после завтра)
    (На этапе базы это будет 3 запроса)

    Затем в view ты будешь
    сначала делать первый первый цикл по ключам (вывести доступные дни)
    И внутри цикла делать цикл что бы вывести погоду для этого конкретного дня.

    как то так.
    Спрашивай вопросы


 $query = "SELECT * FROM tb_test";
$result = mysql_query($query) or die("Couldn't execute query!");
$current_rec = mysql_fetch_array($result) ;
do
$i = $current_rec['id'];
$MyCar[$i]['name'] = $current_rec['carname'];
$MyCar[$i]['voditel'] = $current_rec['drivername'];
$MyCar[$i]['dr_test'] = $current_rec['flag_test'];
while ($current_rec = mysql_fetch_array($result));


 */
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
   /*    foreach($weather_today as $array){

        //   $array = (array)$w;    // stdObject class ---> Array
           $temp_min = $array['temp_min'];
           $temp_max = $array['temp_max'];
           $date = $array['kuupaev'];



           echo "Date: ".$date."<br> Min:".$temp_min."<br> Max: ".$temp_max."<br><p>";
       }*/

    foreach ($array as $key => $avalue) {

        echo "<td>".$key."</td><td>";

        for($i = 0; $i < count($avalue); $i++)
            //echo '<td>'.$avalue[$i].'</td>';
        print_r($avalue[$i]['temp_min']);


        echo '<br /></td></tr>' ;
    }


    echo "</td></tr></table>";














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
