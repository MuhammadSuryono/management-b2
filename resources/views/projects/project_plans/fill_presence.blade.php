<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link href="{{url('../assets/gentelella')}}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Full-width input fields */
        select,
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Set a style for all buttons */
        .btn-custom {
            background-color: #0470aa;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;

        }

        button:hover {
            opacity: 0.8;
        }

        /* Extra styles for the cancel button */
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        /* Center the image and position the close button */
        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
            position: relative;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container-custom {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto;
            /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 25%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        #success_tic .page-body {
            max-width: 300px;
            background-color: #FFFFFF;
            margin: 10% auto;
        }

        #success_tic .page-body .head {
            text-align: center;
        }

        /* #success_tic .tic{
  font-size:186px;
} */
        #success_tic .close-2 {
            opacity: 1;
            position: absolute;
            right: 0px;
            font-size: 30px;
            padding: 3px 15px;
            margin-bottom: 10px;
        }

        #success_tic .checkmark-circle {
            width: 150px;
            height: 150px;
            position: relative;
            display: inline-block;
            vertical-align: top;
        }

        .checkmark-circle .background {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #1ab394;
            position: absolute;
        }

        #success_tic .checkmark-circle .checkmark {
            border-radius: 5px;
        }

        #success_tic .checkmark-circle .checkmark.draw:after {
            -webkit-animation-delay: 300ms;
            -moz-animation-delay: 300ms;
            animation-delay: 300ms;
            -webkit-animation-duration: 1s;
            -moz-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-timing-function: ease;
            -moz-animation-timing-function: ease;
            animation-timing-function: ease;
            -webkit-animation-name: checkmark;
            -moz-animation-name: checkmark;
            animation-name: checkmark;
            -webkit-transform: scaleX(-1) rotate(135deg);
            -moz-transform: scaleX(-1) rotate(135deg);
            -ms-transform: scaleX(-1) rotate(135deg);
            -o-transform: scaleX(-1) rotate(135deg);
            transform: scaleX(-1) rotate(135deg);
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
        }

        #success_tic .checkmark-circle .checkmark:after {
            opacity: 1;
            height: 75px;
            width: 37.5px;
            -webkit-transform-origin: left top;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            transform-origin: left top;
            border-right: 15px solid #fff;
            border-top: 15px solid #fff;
            border-radius: 2.5px !important;
            content: '';
            left: 35px;
            top: 80px;
            position: absolute;
        }

        @-webkit-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @-moz-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @-webkit-keyframes animatezoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }


        @media screen and (max-width: 712px) {

            /* Modal Content/Box */
            .modal-content {
                background-color: #fefefe;
                margin: 5% auto 15% auto;
                /* 5% from the top, 15% from the bottom and centered */
                border: 1px solid #888;
                width: 50%;
                /* Could be more or less, depending on screen size */
            }

        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }

            /* Modal Content/Box */
            .modal-content {
                background-color: #fefefe;
                margin: 5% auto 15% auto;
                /* 5% from the top, 15% from the bottom and centered */
                border: 1px solid #888;
                width: 100%;
                /* Could be more or less, depending on screen size */
            }

        }
    </style>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <div id="id01" class="modal" style="overflow: scroll;">

        <form class="modal-content animate" action="{{url('project_plans/store_presence')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img width="50%" src="{{url('../assets/')}}/images/logo_mri_full.png" alt="" />
            </div>

            <div class="container-custom">
                <input type="hidden" name="id" value="{{$project_plan->id}}">
                <input type="hidden" name="is_respondent" value="{{$is_respondent}}">
                <?php if ($is_respondent) : ?>

                    <div class="form-group">
                        <label for="uname"><b>Nama</b></label>
                        <select name="user" id="" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            @foreach($respondents as $r)
                            <?php $check = DB::table('project_absensi_respondents')->where('project_plan_id', $project_plan->id)->where('respondent_id', $r->id)->first(); ?>
                            <?php if (!$check) : ?>
                                <option value="{{$r->id}}">{{$r->respname}}</option>
                            <?php endif; ?>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="norek">Nomor Rekening/Nomor Handphone </label>
                        <input type="number" title="Isi Nomor Rekening apabila memilih bank dan isi nomor telfon apabile memilih E-wallet" class="form-control tooltipped" id="norek" name="norek"></input>
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank/E-Wallet</label>
                        <select name="bank" id="" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            @foreach($e_wallet as $e)
                            <option value="{{$e->kode}}">{{$e->nama}}</option>
                            @endforeach
                            <option value="" disabled="disabled">─────────────────────────</option>
                            @foreach($bank as $b)
                            <option value="{{$b->kode}}">{{$b->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pemilik_rekening">Nama Pemilik Rekening/E-wallet</label>
                        <input type="text" class="form-control" id="pemilik_rekening" name="pemilik_rekening"></input>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-group">
                            <label for="evidence">Foto Tanda Kehadiran <a type="button" style="color: lightblue; text-decoration: none; cursor: help;" data-toggle="tooltip" data-placement="top" title="Maks. size 5MB"> <i class="fa fa-fw fa-question-circle"></i></a></label>
                            <input type="file" accept="image/*" class="form-control-file" id="evidence" name="evidence">
                            <img id="preview" class="imagen" src="" alt="" style="width: 100%; height: auto;" alt="image" style="display: none;" />
                        </div>
                    </div>
                <?php else : ?>
                    <label for="bank" style="margin-right: 10px;"><b>Nama</b></label>
                    <select name="user" id="" class="selectpicker" data-show-subtext="true" data-live-search="true">
                        @foreach($team as $t)
                        @if(in_array($t->id, $peserta_external))
                        <option value="{{$t->id}}">{{$t->nama}}</option>
                        @endif
                        @endforeach
                    </select>
                <?php endif; ?>

                <button class="btn-custom" type="submit" style="margin-top: 30px;" onclick="alert('Success')">Submit</button>
            </div>
        </form>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script>
    $(window).on('load', function() {

        $('.imagen[src=""]').hide();
        $('.imagen:not([src=""])').show();

        console.log('here');
        $('#id01').show();

        const inputFile1 = $('#file');
        inputFile1.change(function() {
            let string = $(this).val().split('\\');
            $('#fileText').text(string[string.length - 1]);
        })

        $('input[type=text][name=norek]').tooltip({
            placement: "top",
            trigger: "focus"
        });

        evidence.onchange = evt => {
            const [file] = evidence.files
            if (file) {
                preview.src = URL.createObjectURL(file)
                $('#preview').show()
            }
        }
    });
</script>

</html>