<html>
    <head>
        <title>Weather</title>
        <style>
            #table{overflow-x: scroll}

        </style>
    </head>
    <body>
    <?php

    //  echo $town;
    $town_id = DB::table('towns')->where('town', $town)->first();
    $town_id = $town_id->id;
    //print_r($town_id);

    $date_now = date('Y-m-d', time());
    $date_now = $date_now.' 00:00:00';
    DB::table('weather')->where('kuupaev','<', $date_now)->delete();

    $weather = DB::table('weather')->where('town_id', $town_id)->get();
    $weather = (array)$weather; // stdObject class ---> Array
    print_r("
    <div id = 'table'>
        <table border = '1' >
            <tr>
    ");
    foreach($weather as $w){
        $array = (array)$w;    // stdObject class ---> Array
       // print_r($array);
        $temp_min = $array['temp_min'];
        $temp_max = $array['temp_max'];
        $date = $array['kuupaev'];
        echo "<td> Min:".$temp_min."<br> Max: ".$temp_max."<br> Date: ".$date."</td>";
       /* echo "Min: ".$temp_min;
        echo "<br>";
        echo "Max: ".$temp_max;
        echo "<br>";
        echo "Date: ".$date;
        echo "<br>";
        echo "<br>";
*/
    }
    print_r("
            </tr>
        </table>
    </div>
    ");


    ?>



    </body>
</html>
