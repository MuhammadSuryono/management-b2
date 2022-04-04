<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            @include('layouts.gentelella.content_title')

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
                    <div class="card-box table-responsive">
                        @if(isset($cropNotif))
                        <div class="offset-md-3 col-sm-6">
                            @endif
                            @if (session('status'))
                            <div class="x_content bs-example-popovers">
                                <div align="center" class="alert alert-info alert-dismissible " role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Status Proses! </strong> {{ session('status') }}
                                </div>
                                @elseif (session('status-fail'))
                                <div class="x_content bs-example-popovers">
                                    <div align="center" class="alert alert-info alert-dismissible" role="alert" style="background-color: red;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <strong>Status Proses! </strong> {{ session('status-fail') }}
                                    </div>
                                    @endif
                                    @if(isset($add_url))
                                    <a href="{{$add_url}}" class="btn btn-primary btn-block">{{isset($add_title) ? $add_title : 'Add'}} </a>
                                    @endif
                                </div>

                                @if(isset($cropNotif))
                            </div>
                            @endif
                            <table id="datatable-buttons" class="table table-striped table-bordered table-hover tableFixHead" style="width:100%">
