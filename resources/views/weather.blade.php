<!DOCTYPE html>
<html>
    <head>
        <title>Weather</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <style>
            #table{
                margin-left: 1%;
            }
            #text{
                margin-left: 3%;
            }
        </style>
    </head>
    <body>
    <div id="text"><h2>Hello, {{ $town }}. <p></h2></div>
        <?php
          //  print_r($array);
        ?>
        <div id="table">
            <div class="row">
                @foreach ($array as $key => $avalue)
                    @if (count($avalue) > 0)
                            <div class="col-md-2">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="3">{{date("d. F",strtotime($key))}}</td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td>Время</td>
                                        <td>MIN</td>
                                        <td>MAX</td>
                                    </tr>
                                    </tr>
                                    @for ($i = 0; $i < count($avalue) - 1; $i++)
                                        <tr>
                                            <td>{{date("H:i",strtotime($avalue[$i]['kuupaev']))}}</td>
                                            <td>{{$avalue[$i]['temp_min']}}</td>
                                            <td>{{$avalue[$i]['temp_max']}}</td>
                                        </tr>
                                    @endfor
                                </table>
                            </div>
                    @endif
                @endforeach
            </div>
        </div>
    </body>
</html>


