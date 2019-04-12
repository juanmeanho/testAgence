<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Caol Agence Interativa</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet"> <!--Añadimos el css generado con webpack-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    </head>
    <body>
            <div id="app" class="content"><!--La equita id debe ser app, como hemos visto en app.js-->
                <v-app>
                    <example-component></example-component><!--Añadimos nuestro componente vuejs-->
                </v-app>
            </div>
        <script src="{{asset('js/app.js')}}"></script> <!--Añadimos el js generado con webpack, donde se encuentra nuestro componente vuejs-->
    </body>
</html>
