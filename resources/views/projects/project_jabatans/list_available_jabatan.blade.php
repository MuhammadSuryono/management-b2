<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Daftar jabatan untuk area {{ $project_kota->kota->kota }} yang bisa ditambahkan</h2>
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
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="6%">

                                    </th>
                                    <th>Peranan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jabatans as $item)
                                <tr>
                                    <th width="6%">
                                        <input type="checkbox" id="available_jabatan_id[]" name="available_jabatan_id[]" style="width:20px; height:20px" value="{{ $item->id }} ">
                                    </th>
                                    <td>
                                        @if(isset($item->jabatan))
                                        {{$item->jabatan}}
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
<script src="{{url('../assets')}}/js/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#selectAll").click(function() {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    });
</script>