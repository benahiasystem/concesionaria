<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- fabicon.ico -->
        <link  href="/img/favicon.ico" rel="icon" type="image/x-icon"/>
        <title>Concesionaria</title>

    </head>
    <body>
            @extends('layouts.app')

            @section('content')
                <div class="">
                   <reporte-cliente-component></reporte-cliente-component>
                </div>
            @endsection
    </body>
</html>