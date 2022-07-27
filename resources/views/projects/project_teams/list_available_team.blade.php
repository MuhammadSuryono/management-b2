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
            <input class="form-control" value="{{$project_jabatan->project_kota_id}}" name="projectKotaId" hidden>
            @if($project_jabatan->jabatan->jabatan != "Team Leader (TL)")
            <div class="row">
                <div class="col-lg-5">
                    @if($haveLeader)
                    <div class="form-group">
                        <select name="leader" class="form-control" id="select-tl" required>
                            <option value="">Pilih Team Leader</option>
                            @if(($teamLeaders != null))
                                @foreach($teamLeaders->project_team as $leader)
                                    <option data-typeTl="{{$leader->type_tl}}" value="{{ $leader->team->id }}" {{ app('request')->input('leader') == $leader->team->id ? 'selected' : '' }}><strong>{{ $leader->team->nama }}</strong> (<small>{{ucwords($leader->type_tl)}}</small>)</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <p class="text-muted font-13 m-b-30">
                            Pilih semua nama yang ingin ditambahkan, lalu klik Save
                        </p>
                        <div class="table-scroll">
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action table-hover tableFixHead" style="width:100%">
                            <thead>
                                <tr class="warning">
                                    <th width="6%">
                                        <input type="checkbox" id="selectAll" style="width:20px; height:20px"></button>
                                    </th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>HP</th>
                                    <th>Alamat</th>
                                    @if($showColumnHonor)
                                    <th>Honor</th>
                                    @if($showColumnTypeTl)
                                    <th>Jenis TL</th>
                                        @endif
                                    @endif
                                    @if($project_jabatan->jabatan->jabatan == "Team Leader (TL)")
                                        <th>Target</th>
                                    @endif
                                    <th>Rate Card</th>
                                </tr>
                            </thead>
                            <tbody id="body-teams">

                            @if($showTeam)
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
                                                @if($item->gender_id==1)
                                                    Laki-laki
                                                @else
                                                    Perempuan
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $item->hp }} </td>
                                        <td>{{ $item->alamat }} </td>
                                        @if($showColumnHonor)
                                        <td>
                                            <div class="item form-group">
                                                <input type="text" id="honor-{{$item->id}}" name="honor[]" class="form-control honor" disabled="true" value="">
                                            </div>
                                        </td>
                                            @if($showColumnTypeTl)
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" name="jenis_tl[]" id="jenis_tl-{{$item->id}}" disabled="true">
                                                    <option value="">Pilih Jenis TL</option>
                                                    <option value="reguler" {{app('request')->input('type_tl') == 'reguler' ? 'selected':''}}>Reguler</option>
                                                    <option value="borongan" {{app('request')->input('type_tl') == 'borongan' ? 'selected':''}}>Borongan</option>
                                                </select>
                                            </div>
                                        </td>
                                            @endif
                                        @endif
                                        @if($project_jabatan->jabatan->jabatan == "Team Leader (TL)")
                                            <td>
                                                <div class="item form-group">
                                                    <input type="text" id="target-{{$item->id}}" name="target[]" class="form-control honor" disabled="true" value="">
                                                </div>
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            @if($item->rate_card)
                                                <a href="{{url('/projects/view')}}/{{$item->rate_card}}" target="_blank"> <i class="fa fa-eye"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="{{url('../assets')}}/js/jquery.min.js"></script> -->
@section('javascript')
<script>

    $('#select-tl').change(() => {
        let typeTl = $('#select-tl option:selected').data('typetl')
        let value = $('#select-tl option:selected').val()
        let projectJabatan = "{{$project_jabatan->id}}"
        let team = "{{$project_jabatan->jabatan->jabatan}}"
        let path = `/project_teams/create/${projectJabatan}?type_tl=${typeTl}&leader=${value}&team=${team}`
        window.location.href = "{{url("")}}" + path
    })
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
                    $(`#target-${e.value}`).prop('required', false);
                    $(`#target-${e.value}`).prop('disabled', false);
                } else {
                    $(`#honor-${e.value}`).val('');
                    $(`#honor-${e.value}`).prop('disabled', true);
                    $(`#jenis_tl-${e.value}`).prop('disabled', true);
                    $(`#honor-${e.value}`).prop('required', false);
                    $(`#jenis_tl-${e.value}`).prop('required', false);
                    $(`#target-${e.value}`).prop('required', true);
                    $(`#target-${e.value}`).prop('disabled', true);
                }
            })
        });
    });
</script>
@endsection
