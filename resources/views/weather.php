<html>
    <head>
        <title>Weather</title>
        <style>
            #table{overflow-x: scroll}
        </style>
    </head>
    <body>
        <table border='1'>
            <tr>


                <?php
                foreach ($array as $key => $avalue) {
                    echo "<td>" . date("d. F",strtotime($key)) . "</td>";
                    for ($i = 0; $i < count($avalue) - 1; $i++)
                        echo '<td>' . date("H:i",strtotime($avalue[$i]['kuupaev'])) . '<br/>Min: ' . $avalue[$i]['temp_min'] . '<br/>Max: ' . $avalue[$i]['temp_max'] . '</td><br /></td></tr>';
                }
                ?>
    </body>
</html>