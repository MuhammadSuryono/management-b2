<?php $acc_menu = session('accessible_menus');?>
<div class="menu_section">
    <h2 class="text-light bg-primary">Project Moduls</h2>
    <ul class="nav side-menu">
        {{-- PROJECT --}}
        <li><a><i class="fa fa-gears"></i> Project <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if( array_search('Project', $acc_menu,TRUE))
                    <li><a href="{{url('/projects')}}">Project</a></li>
                @endif
                @if( array_search('Absensi', $acc_menu,TRUE))
                    <li><a href="{{url('/project_absensis')}}">Absensi</a></li>
                @endif  
                @if( array_search('Scan QR', $acc_menu,TRUE))
                    <li><a href="{{url('/project_absensis/scanqr')}}">Scan QR</a></li>
                @endif
            </ul>
        </li>

        {{-- RESPONDENT --}}
        <li><a><i class="fa fa-users"></i> Responden<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if( array_search('Respondents', $acc_menu,TRUE))
                    <li class="sub_menu"><a href="{{url('/respondents')}}">Respondents</a></li>
                @endif
                @if( array_search('Import Respondents', $acc_menu,TRUE))
                    <li><a href="{{url('/import_excels')}}">Import Respondents</a></li>
                @endif
                @if( array_search('Project Imported', $acc_menu,TRUE))
                    <li><a href="{{url('/project_importeds')}}">Project Imported</a></li>
                @endif
                @if( array_search('Produk yg dimiliki', $acc_menu,TRUE))
                    <li><a href="{{url('/kategori_produks')}}">Produk yg dimiliki</a></li>
                @endif
            </ul>
        </li>
        
        <li><a><i class="fa fa-comments"></i>Team<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if( array_search('Teams', $acc_menu,TRUE))
                    <li class="sub_menu"><a href="{{url('/teams')}}">Teams</a></li>
                @endif
                @if( array_search('Bahasa Asing', $acc_menu,TRUE) )
                    <li><a href="{{url('/bahasas')}}">Bahasa Asing</a></li>
                @endif
                @if( array_search('Jabatan Team', $acc_menu,TRUE))
                    <li><a href="{{url('/jabatans')}}">Jabatan Team</a></li>
                @endif
            </ul>
        </li>

        <li><a><i class="fa fa-cubes"></i>Project components<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if( array_search('Task List', $acc_menu,TRUE))
                    <li class="sub_menu"><a href="{{url('/tasks')}}">Task List</a></li>
                @endif
                @if( array_search('Lokasi Kegiatan', $acc_menu,TRUE))
                    <li class="sub_menu"><a href="{{url('/lokasis')}}">Lokasi Kegiatan</a></li>
                @endif
            </ul>
        </li>
    </ul>
    <h2 class="text-light bg-primary">Finance</h2>
    <ul class="nav side-menu">
                {{-- MENU BUDGET --}}
                @if( array_search('Budget (Direksi)', $acc_menu,TRUE))
                <li>
                    <a href="{{url('/budgets')}}"><i class="fa fa-bitcoin"></i> Budget (Direksi)<span class="fa fa-chevron-down"></span></a>
                    {{-- <ul class="nav child_menu">
                        <li><a href="{{url('/projects')}}">Projects</a></li>
                    </ul> --}}
                </li>
            @endif
            @if( array_search('Budget (Staff)', $acc_menu,TRUE)) 
                <li class=""> 
                    {{-- {{Request::segment(1)==='budgets'?'active':''}} --}}
                    <a><i class="fa fa-bitcoin"></i> Budget (Staff)<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li class=""><a href="{{url('/budgets/divisi')}}">Input Budget</a></li>
                        <li><a href="{{url('/budgets/pengajuan')}}">Pengajuan Budget</a></li>
                    </ul>
                </li>
            @endif
            {{-- AKHIR MENU BUDGET --}}
    </ul>
    <h2 class="text-light bg-primary">General</h2>
    <ul class="nav side-menu">
        <li><a><i class="fa fa-circle-o"></i>Umum<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if( array_search('Kota', $acc_menu,TRUE))
                    <li class="sub_menu"><a href="{{url('/kotas')}}">Kota</a></li>
                @endif
                @if( array_search('Pendidikan', $acc_menu,TRUE))
                    <li><a href="{{url('/pendidikans')}}">Pendidikan</a></li>
                @endif
                @if( array_search('Pekerjaan', $acc_menu,TRUE))
                    <li><a href="{{url('/pekerjaans')}}">Pekerjaan</a></li>
                @endif
            </ul>
        </li>
        

        <li><a><i class="fa fa-edit"></i> Administrator <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @if( array_search('User', $acc_menu,TRUE)) 
                    <li><a href="{{url('/users')}}">User</a></li>
                @endif
                @if( array_search('Roles', $acc_menu,TRUE)) 
                    <li><a href="{{url('/roles')}}">Roles</a></li>
                @endif
                @if( array_search('Menus', $acc_menu,TRUE)) 
                    <li><a href="{{url('/menus')}}">Menus</a></li>
                @endif
                @if( array_search('Reset Password', $acc_menu,TRUE)) 
                    <li><a href="{{url('/users/reset_password')}}">Reset Password</a></li>
                @endif
            </ul>

        </li>
    </ul>
</div>
