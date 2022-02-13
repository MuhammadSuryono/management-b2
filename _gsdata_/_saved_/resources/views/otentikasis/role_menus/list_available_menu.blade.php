
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Daftar menu untuk role {{ $role->role_login }} yang bisa ditambahkan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" menu="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                                    <th align="right">Pilih</th>
                                    <th>Menu</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $item)
                                <tr>
                                    <td scope='row' align="right">
                                        <input type="checkbox" id="available_menu_id[]" name="available_menu_id[]" class="flat" value="{{ $item->id }} ">
                                    </td>
                                    <td>
                                        @if(isset($item->menu))
                                            {{$item->menu}}
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
