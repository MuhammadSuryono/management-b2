@if(session('status-fail') != null)
    <div class="alert alert-danger">
        {{ session('status-fail') }}
    </div>
@endif
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
            @if($project_jabatan->jabatan->jabatan != "Team Leader (TL)")
            <div class="row">
                <div class="col-lg-5">
                    <div class="form-group">
                        <select name="leader" class="form-control" required>
                            <option value="">Pilih Team Leader</option>
                            @if(($teamLeaders != null))
                                @foreach($teamLeaders->project_team as $leader)
                                    <option value="{{ $leader->team->id }}" {{ app('request')->input('leader') == $leader->team->id ? 'selected' : '' }}>{{ $leader->team->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <p class="text-muted font-13 m-b-30">
                            Pilih semua nama yang ingin ditambahkan, lalu klik Save
                        </p>
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="6%">
                                        <input type="checkbox" id="selectAll" style="width:20px; height:20px"></button>
                                    </th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>HP</th>
                                    <th>Alamat</th>
                                    <th>Honor</th>
                                    <th>Jenis TL</th>
                                    <th>Rate Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teams as $item)
                                <tr>
                                    <th width="6%">
                                        <input type="checkbox" id="available_team_id[]" class="checkboxHonor" name="available_team_id[]" style="width:20px; height:20px" value="{{ $item->id }} ">
                                    </th>

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
                                    <td>
                                        <div class="item form-group">
                                            <input type="text" id="honor-{{$item->id}}" name="honor[]" class="form-control honor" disabled="true" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="jenis_tl[]" id="jenis_tl-{{$item->id}}" disabled="true">
                                                <option value="">Pilih Jenis TL</option>
                                                <option value="reguler">Reguler</option>
                                                <option value="borongan">Borongan</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->rate_card)
                                        <a href="{{url('/projects/view')}}/{{$item->rate_card}}" target="_blank"> <i class="fa fa-eye"></i></a>
                                        @endif
                                    </td>
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

<!-- <script src="{{url('../assets')}}/js/jquery.min.js"></script> -->
@section('javascript')
<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            if ($(this).is(':checked')) {
                $(".honor").prop('disabled', false);
            } else {
                $(".honor").prop('disabled', true);
            }
        });

        const checkbox = document.querySelectorAll(".checkboxHonor");
        checkbox.forEach(function(e, i) {
            e.addEventListener("change", function() {
                if (e.checked) {
                    $(`#honor-${e.value}`).prop('disabled', false);
                    $(`#jenis_tl-${e.value}`).prop('disabled', false);
                    $(`#honor-${e.value}`).prop('required', true);
                    $(`#jenis_tl-${e.value}`).prop('required', true);
                } else {
                    $(`#honor-${e.value}`).val('');
                    $(`#honor-${e.value}`).prop('disabled', true);
                    $(`#jenis_tl-${e.value}`).prop('disabled', true);
                    $(`#honor-${e.value}`).prop('required', false);
                    $(`#jenis_tl-${e.value}`).prop('required', false);
                }
            })
        });
    });
</script>
@endsection
