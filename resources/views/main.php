<html>
    <head>
        <title>Weather</title>
    </head>
    <body>
        <form action="/weather" method="POST">
            <input type="text" placeholder="Enter your town" name="town"/>
            <input type="submit" value="Send">
        </form>
        <table border="1">
            <th>Страна</th>
            <?php
                $result = array();
                foreach ($array as $key => $value) {
                    $result[] = $value->town;
                }
               //print_r($result);
                foreach($result as $value){
                  echo "<tr><td><a href='#'>".$value."</a></td></tr>";
                }
            ?>
        </table>
    </body>
</html>