
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Daftar {{ $project_jabatan->jabatan->jabatan }} yang bisa ditambahkan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <p class="text-muted font-13 m-b-30">
                        Pilih semua nama yang ingin ditambahkan, lalu klik Save
                        </p>
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                            <thead>
                                <tr>
                                    <th align="right">Pilih</th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>HP</th>
                                    <th>Alamat</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teams as $item)
                                <tr>
                                    <td scope='row' align="right">
                                        <input type="checkbox" id="available_team_id[]" name="available_team_id[]" class="flat" value="{{ $item->id }} ">
                                    </td>
                                    <td>
                                        @if(isset($item->nama))
                                            {{$item->nama}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($item->gender_id))
                                            @if($item->gender_id=1)
                                                Laki-laki
                                            @else
                                                Perempuan
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $item->hp }} </td>
                                    <td>{{ $item->alamat }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
