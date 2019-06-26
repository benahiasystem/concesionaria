<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name',    'Concesionaria') }}</title>

    <!-- fabicon.ico -->
    <link  href="img/favicon.ico" rel="icon" type="image/x-icon"/>



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <!--Import Google Icon Font-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <!-- Compiled and minified CSS -->
    <link href="{{ asset('css/Materialize-1.0.0.min.css') }}" rel="stylesheet">
    
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">

      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>
<body>

    <div id="app">
        <v-app>
            
            @guest

                @if (Route::has('register'))
                    <!-- vista sin login-->
                    <toolbar1-component></toolbar1-component>   
                    
                @endif
            
                @else 
                    <!-- meta se envia el nombre de usuario autenticado a vuetify-->
                    <meta name="auth-user" content="{{ Auth::user()->name }}">
                    <meta name="api_token" content="{{ Auth::user()->api_token }}">
                    <!-- vista con login-->
                    <toolbar2-component> </toolbar2-component>
                    
            @endguest

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                
            <br>
            <br>    
        
            <main class="py-4">
                @yield('content')
                <footer-component> </footer-component>
            </main>
        </v-app>
    </div>
</body>

 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>

 <!-- Jquery minified -->
 <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    
 <!-- Compiled and minified JavaScript -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</html>
