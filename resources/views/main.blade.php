<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>MRI B2</title>

    <!-- Bootstrap -->
    <link href="{{url('assets/gentelella')}}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('assets/gentelella')}}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- NProgress -->
    <link href="{{url('assets/gentelella')}}/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{url('assets/gentelella')}}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{url('assets/gentelella')}}/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{url('assets/gentelella')}}/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{url('assets/gentelella')}}/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{url('assets/gentelella')}}/build/css/custom.min.css" rel="stylesheet">

    @if(isset($head_script_include))
        @include($head_script_include)
    @endif
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ url('/') }}" class="site_title"> <span>MRI B2</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{ url('assets/images/user_logo.png') }}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Selamat Datang,</span>
                        <h2>{{ session('nama') }}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                @include('layouts.gentelella.sidebar')
            </div>
        </div>

        <!-- top navigation -->
{{--        @include('layouts.gentelella.top_nav')--}}
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('layouts.gentelella.footer')
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{url('assets/gentelella')}}/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{url('assets/gentelella')}}/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="{{url('assets/gentelella')}}/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="{{url('assets/gentelella')}}/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="{{url('assets/gentelella')}}/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="{{url('assets/gentelella')}}/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="{{url('assets/gentelella')}}/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="{{url('assets/gentelella')}}/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="{{url('assets/gentelella')}}/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="{{url('assets/gentelella')}}/vendors/Flot/jquery.flot.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/Flot/jquery.flot.pie.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/Flot/jquery.flot.time.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/Flot/jquery.flot.stack.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="{{url('assets/gentelella')}}/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="{{url('assets/gentelella')}}/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="{{url('assets/gentelella')}}/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{url('assets/gentelella')}}/vendors/moment/min/moment.min.js"></script>
<script src="{{url('assets/gentelella')}}/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="{{url('assets/gentelella')}}/build/js/custom.min.js"></script>
@yield('script')
</body>
</html>
