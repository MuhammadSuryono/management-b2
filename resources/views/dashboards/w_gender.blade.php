<div class="x_panel tile fixed_height_320">
    <div class="x_title">
      <h2>Gender Responden</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
        </li>
        <li>
          <a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
      <h4>Komposisi Gender responden</h4>
      @foreach($gender as $item)
      <div class="widget_summary">
        <div class="w_left w_25">
          <span>{{ $item->gender }} </span>
        </div>
        <div class="w_center w_55">
          <div class="progress">
            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:  {{floor($item->jumlah / $total_respondent * 100) . '%' }};">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
        </div>
        <div class="w_right w_20">
          <span>{{ $item->jumlah }} </span>
        </div>
        <div class="clearfix"></div>
      </div>
      @endforeach

    </div>
