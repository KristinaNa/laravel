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
<div id="text">
    <h2>Hello, {{ $town }}. <p></h2>
</div>

<div id="table">
    <div class="row">
        @foreach ($data as $array)
            <div class="col-md-2">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="3">{{date("d. F",strtotime($array[0]['kuupaev']))}}</td>
                    </tr>
                    <tr>
                        <tr>
                            <td>Time</td>
                            <td>MIN</td>
                            <td>MAX</td>
                        </tr>
                    </tr>
                    @foreach ($array as $avalue)
                        <tr>
                            <td>{{date("H:i",strtotime($avalue['kuupaev']))}}</td>
                            <td>{{$avalue['temp_min']}}</td>
                            <td>{{$avalue['temp_max']}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach

    </div>
    <a href="#">refresh</a>
</div>

</body>
</html>


