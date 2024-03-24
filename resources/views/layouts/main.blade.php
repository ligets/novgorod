<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @vite('resources/css/header.css')
    @vite('resources/css/reset.css')
    @vite('resources/css/scrollbar.css')
    @vite('resources/css/footer.css')
    @vite('resources/css/modal.css')
    @yield('style')
    <!-- <title>Hosting</title>  -->
    <title>@yield('title-block')</title>
</head> 
<body class="col-md-12 loaded">
    @include('includes.header')

    @yield('content')

    @include('includes.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <!-- @vite('resources/js/load-form.js') -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite('resources/js/theme-switch.js')
    <script>
        $('#searchCont').select2({
            placeholder: "Поиск по тегам...",
            width: 'auto',
            height: '38px'
        })
    </script>
    @yield('scripts')
</body> 
</html>