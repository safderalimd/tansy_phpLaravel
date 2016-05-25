<!DOCTYPE html>
<html>
    <head>
        <title>Debug</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <style type="text/css">
            th {
                width: 150px;
            }
            table {
                margin-top: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Procedure Name</th>
                        <td>{{d(session('debug-info-procedure'))}}</td>
                    </tr>
                    <tr>
                        <th>Input Params</th>
                        <td>{{d(session('debug-info-iparams'))}}</td>
                    </tr>
                    <tr>
                        <th>Output Params</th>
                        <td>{{d(session('debug-info-oparams'))}}</td>
                    </tr>
                </tbody>
            </table>

            <table style="display:none;" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select Sql</th>
                        <th>Parameters</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // $selects = session('debug-info-select');
                        // if (!is_array($selects)) {
                        //     $selects = [[null]];
                        // }
                        $selects = [];
                    ?>
                    @foreach ($selects as $row)
                    <tr>
                        <td>{{d(array_shift($row))}}</td>
                        <td>{{d($row)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </body>
</html>
