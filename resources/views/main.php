<html>
    <head>
        <title>Main page</title>
    </head>
    <body>
        <form action="/weather" method="POST">
            <input type="text" placeholder="Enter your town" name="town"/>
            <input type="submit" value="Send">
        </form>
        <table border="1">
            <th>Страна</th>
            <?php
            $towns = DB::table('towns')->get();
            foreach ($towns as $town) {
                $array = (array)$town;
                $town = $array['town'];
                echo "<tr><td><a href='/weather/$town'</a>".$town."</td></tr>";
            }
            ?>
        </table>
    </body>
</html>