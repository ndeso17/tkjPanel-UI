<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tkjPanel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('custom/style.css') }}">
</head>

<body id="body-pd">
    <header class="header" id="header">
        <x-header />
    </header>
    <div class="l-navbar" id="nav-bar">
        <x-navbar />
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light">
        <h4>tkjPanel Tools</h4>
        <div class="bungkus">
            @yield('konten')
        </div>
    </div>
    <!--Container Main end-->
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#toggleSidebar').click(function() {
            $('.sidebar').toggleClass('minimized');
        });
    });
</script>
<script src="{{ asset('custom/style.js') }}"></script>

</html>
