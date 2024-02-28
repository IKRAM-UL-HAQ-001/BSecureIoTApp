<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Speed Control</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <style>
            .speed-display {
            font-size: 24px;
            text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h1 class="text-center">Speed Control</h1>
                    <div class="speed-display mb-3">Speed: 
                        <table>
                            <tr>
                                {{$speed}}  km/h
                            </tr>
                        </table>
                    </div>
                    <div class="text-center">
                        <form method="POST" action="{{ route('iotdevices.speed')}}">
                            @csrf
                            <input type="hidden" value="up" name="direction" id="direction">
                            <input type="hidden" value="{{ $iotid }}" name="iotid" id="iotid">
                            <input type="hidden" value="{{ $speed }}" name="speed" id="speed">

                            <button type="submit" class="btn btn-primary" data-direction="up">&#8593; Speed Up</button>
                        </form>
                        <form  method="POST" action="{{ route('iotdevices.speed')}}">
                            @csrf
                            <input type="hidden" value="down" name="direction" id="direction">
                            <input type="hidden" value="{{ $iotid }}" name="iotid" id="iotid">
                            <input type="hidden" value="{{ $speed }}" name="speed" id="speed">

                            <button type="submit" class="btn btn-danger" data-direction="down">&#8595; Slow Down</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
