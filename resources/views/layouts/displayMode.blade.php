<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('style/style.css')}}" />



    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Chase It Global</title>

    <!-- Bootstrap CSS (version 5) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">


    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <!-- Bootstrap JS (version 5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-csP6iU5nV61F/0YJSdy6Q6d8D99n0GQbIWTJElas5u2v2SH78XGe2FjJS4eP74Wv" crossorigin="anonymous">
    </script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

</head>

<body style=" padding: 0;">

    <main class="">
        <style>
            body main .datatable-container {
                position: absolute;
                width: 100% !important;
                top: 0 !important;
                left: 0 !important;
                height: 100% !important;
                display: flex;
                align-items: flex-start;
                justify-content: start;
                margin: 0;
            }
        </style>
        @yield('content')
    </main>

    @stack('scripts')
    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });

        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && (event.key === 'a' || event.key === 'c' || event.key === 'x' || event.key === 'u')) {
                event.preventDefault();
            }
        });
    </script>
    <script src="{{asset('js/index.js')}}"></script>
</body>

</html>