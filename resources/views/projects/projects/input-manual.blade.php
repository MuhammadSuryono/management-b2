@extends('main')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel mt-2">
                <div class="x_title">
                    <h2><a href="{{url('projects/' . $projectId . '/edit')}}" style="text-decoration: none"><i class="fa fa-arrow-left"></i> Kembali</a> &nbsp;&nbsp;&nbsp;<b><i class="fa fa-money"></i> Project Denda Input Manual</b></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h6 class="font-weight-bold"><i class="fa fa-building"></i> Project: {{strtoupper($project->nama)}}</h6>
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Pilih Kota Project</label>
                                        <select class="form-control" name="project-kota" id="project-kota">
                                            <option value="" disabled>Pilih Project Kota</option>
                                            @foreach($project->project_kota as $kota)
                                                <option value="{{$kota->id}}" {{$kota->id == ($_GET["projectKotaId"] ?? 0) ? 'selected':''}}>{{$kota->kota->kota}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Pilih Variable Denda Kota</label>
                                        <select class="form-control" name="variable-denda" id="variable-denda">
                                            <option value="">Pilih Variable Denda Kota</option>
                                            @foreach($dendaVariable as $denda)
                                                <option value="{{$denda->id}}" {{$denda->id == ($_GET['variable'] ?? 0) ? 'selected':''}}>{{$denda->variable->variable_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($headerTable != "")
                        <div class="alert alert-info" role="alert">
                            Untuk mencari data pada table dapat menggunakan pencarian pada browser dengan menekan <b>CTRL + F</b>
                        </div>
                    @endif
                    @if (\Illuminate\Support\Facades\Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! \Illuminate\Support\Facades\Session::get('success') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$errors->first()}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{$actionSave}}" method="POST">
                        @csrf
                        <div class="table-scroll">
                            <table class="table table-striped table-bordered table-hover tableFixHead" id="table-paginate" style="width:100%">
                                {!! $headerTable !!}
                                {!! $bodyTable !!}
                            </table>
                        </div>
                        @if($headerTable != "")
                            <button class="btn btn-success" type="submit" style="float: right"><i class="fa fa-save"></i> Submit</button>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        $('#project-kota').on('change', function() {
            window.location.href = `${window.location.pathname}?projectKotaId=${this.value}`
        });

        $('#variable-denda').on('change', function() {
            var projectKotaId = params.projectKotaId
            if(projectKotaId === null) {
                alert("Pilih porject kota terlebih dahulu")
            } else {
                window.location.href = `${window.location.pathname}?projectKotaId=${projectKotaId}&variable=${this.value}`
            }

        });
    </script>
@endsection
