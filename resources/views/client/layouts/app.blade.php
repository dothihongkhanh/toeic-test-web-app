<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', config('app.name'))</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
    <link href="/template/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="/template/client/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/template/client/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template/client/css/jquery-ui.css">
    <link rel="stylesheet" href="/template/client/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/template/client/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/template/client/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="/template/client/css/jquery.fancybox.min.css">

    <link rel="stylesheet" href="/template/client/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="/template/client/fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="/template/client/css/aos.css">

    <link rel="stylesheet" href="/template/client/css/style.css">

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <div class="site-wrap">

        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        @include('client.layouts.header')
        @yield('content')
        @include('client.layouts.footer')

    </div>
    @include('client.layouts.javascript')

</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('myModal');
        var btn = document.getElementById('openModalButton');
        var span = document.getElementsByClassName('close')[0];

        btn.onclick = function() {
            modal.style.display = 'block';
        }

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    });
</script>
</html>