@extends('maingentelellatable')
@section('title', 'Daftar Interviewer : ' )
@section('content')

{{-- Filter --}}
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

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/respondent_gift/pengajuan_gift')}}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <!-- Project -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="project_imported_id">Project</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="project_imported_id" name="project_imported_id" class="form-control pull-right">
                                                        <option value="all">All</option>
                                                        @foreach($project_importeds as $db)
                                                        @if(isset($_GET['project_imported_id']) and $_GET['project_imported_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['project_imported']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['project_imported']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Kota -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="kota_id">Kota</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="kota_id" name="kota_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($kotas as $db)
                                                        @if(isset($_GET['kota_id']) and $_GET['kota_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['kota']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['kota']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">
                                        </div>

                                    </div>
                                    <div align="center" class="form-group">
                                        <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a>
                                        <button type="submit" class="btn btn-info"> Show </button>
                                        <?php
                                        $request = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING']))ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING'])) ;
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

@include('layouts/gentelella/table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Respondent</th>
        <th>Kota</th>
        <th>Kelurahan</th>
        <th>Alamat</th>
        <th>No. Telp</th>
        <th>Email</th>
        <th>Jenis Kelamin</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php $total = 0; ?>
    @foreach($respondents as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->respname}}</td>
        <td>
            @if(isset($item->kota->kota))
            {{$item->kota->kota}}
            @endif
        </td>
        <td>
            @if(isset($item->kelurahan->kelurahan))
            {{$item->kelurahan->kelurahan}}
            @endif
        </td>
        <td>
            @if(isset($item->address))
            {{$item->address}}
            @endif
        </td>
        <td>{{$item->mobilephone}}</td>
        <td>
            @if(isset($item->email))
            {{$item->email}}
            @endif
        </td>
        <td>
            @if(isset($item->gender->gender))
            {{$item->gender->gender}}
            @endif
        </td>
        <td>
            <button class='btn btn-primary btn-sm' id="btn-ajukan" type="button" data-toggle="modal" data-target="#ajukanModal" data-id="<?= $item->id ?>"><i class="fa fa-chevron-circle-right"></i></button>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')

<!-- Modal -->
<div class="modal fade" id="ajukanModal" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajukanModalLabel">Konfirmasi Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/respondent_gift/change_status')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="nextStatus" value="1">
                    <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    Klik Submit untuk melakukan pengajuan
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('javascript')
<script>
    $('#btn-ajukan').click(function() {
        $('input[name=id]').val($(this).data('id'));
    })

    $(document).ready(function() {
        $('.card-box.table-responsive a').hide();
    });
</script>
@endsection
