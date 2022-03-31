<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MRI B2 | @yield('title')</title>

    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{url('../assets/gentelella')}}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('../assets/gentelella')}}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{url('../assets/gentelella')}}/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{url('../assets/gentelella')}}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Switchery -->
    <link href="{{url('../assets/gentelella')}}/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/build/css/custom.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    @yield('style')
</head>

<style>
    .content-height {
        min-height: auto !important;
    }
</style>

<style>
    .table-scroll {
        max-height: 380px;
        overflow: auto;
        display: inline-block;
        width: 100%;
        scrollbar-width: none;
    }
    .tableFixHead          {
        overflow: auto;
        height: 100px;
    }
    .tableFixHead thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1;
        background: #2A3F54;
        color: white;
        border-color: white;
    }
</style>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    @include('layouts.gentelella.top_left_logo')
                    <!-- sidebar menu -->
                    @include('layouts.gentelella.sidebar')
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            @include('layouts.gentelella.top_nav')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col content-height" role="main">

                <div class="">
                    @yield('content')
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            @include('layouts.gentelella.footer')
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{url('../assets/gentelella')}}/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{url('../assets/gentelella')}}/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="{{url('../assets/gentelella')}}/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="{{url('../assets/gentelella')}}/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="{{url('../assets/gentelella')}}/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Switchery -->
    <script src="{{url('../assets/gentelella')}}/vendors/switchery/dist/switchery.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{url('../assets/gentelella')}}/build/js/custom.min.js"></script>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    @yield('js')
    {{-- @yield('javascript') --}}

    <script>
        $(document).ready(function() {
            // $('a.btn.btn-default.buttons-copy.buttons-html5.btn-sm').show();
            // $('a.btn.btn-default.buttons-csv.buttons-html5.btn-sm').show();
            // $('a.btn.btn-default.buttons-excel.buttons-html5.btn-sm').show();
            // $('a.btn.btn-default.buttons-pdf.buttons-html5.btn-sm').show();
            $('a.btn.btn-default.buttons-copy.buttons-html5.btn-sm').addClass('border');
            $('a.btn.btn-default.buttons-csv.buttons-html5.btn-sm').addClass('border');
            $('a.btn.btn-default.buttons-excel.buttons-html5.btn-sm').addClass('border');
            $('a.btn.btn-default.buttons-pdf.buttons-html5.btn-sm').addClass('border');
            $('a.btn.btn-default.buttons-print.btn-sm').addClass('border');
            $('div.dt-buttons.btn-group').prepend(`
        <button type="button" class="btn btn-primary btn-sm">Export to </button>
        `);
        })
        const sukses = $('.sukses').data('flashdata');

        if (sukses) {
            Swal.fire({
                title: 'Berhasil',
                text: sukses,
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
            });
        }

        const gagal = $('.gagal').data('flashdata');

        if (gagal) {
            Swal.fire({
                title: 'Gagal',
                text: gagal,
                icon: 'error',
                showConfirmButton: false,
                timer: 2500,
            });
        }

        const hapus = $('.hapus').data('flashdata');

        if (hapus) {
            Swal.fire({
                title: 'Hapus',
                text: hapus,
                icon: 'warning',
                showConfirmButton: false,
                timer: 2500,
            });
        }

        const edit = $('.edit').data('flashdata');

        if (edit) {
            Swal.fire({
                title: 'Edit',
                text: edit,
                icon: 'info',
                showConfirmButton: false,
                timer: 2500,
            });
        }

        $('.tombol-hapus').click(function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            Swal.fire({
                    title: 'Anda Yakin ?',
                    text: 'Apakah Anda Yakin Akan Menghapus Data Ini..?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.value) {
                        document.location.href = href;
                    }
                });
        });

        $('.selectpicker').selectpicker();
    </script>
    @yield('javascript')
</body>

</html>
