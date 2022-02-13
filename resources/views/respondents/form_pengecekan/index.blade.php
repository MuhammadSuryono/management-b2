@extends('maingentelellatable')
@section('title', 'Data Form Pengecekan Rekaman : ' . $dataPengecekan->count())
@section('content')

<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Filter:</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <p class="text-muted font-13 m-b-30">
                            Filter kriteria yang anda pilih:
                        </p>

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/form_pengecekan')}}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <!-- Project -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="project_id">Project</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="project_id" name="project_id" class="form-control pull-right">
                                                        <option value="all">All</option>
                                                        @foreach($projects as $db)
                                                        @if(isset($_GET['project_id']) and $_GET['project_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['nama']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['nama']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">

                                        </div>

                                    </div>
                                    <div align="center" class="form-group">
                                        <!-- <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a> -->
                                        <button type="submit" class="btn btn-info"> Show </button>
                                        <?php
                                        $request = ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING']));
                                        ?>
                                        <!-- <a href="{{url('respondents/pick_respondent?')}}{{$request}}" type="button" class="btn btn-info" id="btn-pick-respondent">Pick Respondent </a> -->
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Project</th>
        <th>Nama Respondent</th>
        <th>Interviewer</th>
        <?php
        foreach ($statusPengecekan as $sp) : ?>
            <th>{{$sp->keyword}}</th>
        <?php endforeach; ?>
        <th>Temuan</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($dataPengecekan as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($item->respondent->project->nama))
            {{$item->respondent->project->nama}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($item->respondent->respname))
            {{$item->respondent->respname}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            <?php
            if (isset($item->respondent->srvyr)) :
                if ($item->respondent->srvyr) {
                    $pwtCode = substr($item->respondent->srvyr, 3, 6);
                    $pwtCode = (int)$pwtCode;

                    $cityCode = substr($item->respondent->srvyr, 0, 3);
                    $cityCode = (int)$cityCode;

                    $pwt = DB::table('teams')
                        ->where('no_team', $pwtCode)
                        ->where('kota_id', $cityCode)
                        ->first();

                    if ($pwt) {
                        echo $pwt->nama;
                    } else {
                        echo "Kosong";
                    }
                } else {
                    echo "Kosong";
                }
            else :
                echo "Kosong";
            endif;
            ?>
        </td>
        @foreach($statusPengecekan as $sp)
        <?php $status = $sp->code; ?>
        <td>
            @if($item->$status == 0)
            Tidak
            @else
            Ya
            @endif
        </td>
        @endforeach
        <td>{{$item->temuan}}</td>
        <td>{{$item->created_at}}</td>
        <td>{{$item->updated_at}}</td>
        <td>
            <a href="{{ url('/form_pengecekan/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/form_pengecekan/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')

@section('javascript')
<script>
    $('.card-box.table-responsive a.btn-block').hide();


    $(document).ready(function() {
        $('.buttons-csv').click(function() {
            const project_id = $('#project_id').val();
            $.ajax({
                url: "{{url('/form_pengecekan/set_on_notif')}}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    project_id: project_id
                },
                success: function(hasil) {
                    console.log(hasil);
                }
            })
        })

        if ($('#project_id').val() != 'all') {
            $('.dt-buttons').show();
        } else {
            $('.dt-buttons').hide();
        }
    })
</script>
@endsection