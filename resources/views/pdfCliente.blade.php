<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Styles -->
        <link href="{{ asset('css/Materialize-1.0.0.min.css') }}" rel="stylesheet">
       
        <title>Reportes</title>

    </head>
    <body>
           
            <div class="row mb4">
                    <div class="col s2"><p>fecha desde hasta</p></div>
                    <div class="col s12 m7 l2 bold italic"><h5>Reporte Clientes</h5></div>
                    
            </div>
            <br><br>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->apellido }}</td>
                        <td>{{ $cliente->identificacion }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->direccion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

    </body>
</html>
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>