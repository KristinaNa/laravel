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
            <?php //foreach($arrayInView as $item):    ?>
                <tr><td><a href="/weather/my/weather/<?//php echo $item->name ?>"><?php //echo $item->town ?> </td></tr>
            <?php // endforeach ?>
        </table>


        Привет, <?php echo $name; ?>.

    </body>

</html>