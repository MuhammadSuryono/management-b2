<div class="top_nav">
        <div class="nav_menu">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    @if(session('logged_in')==true) )
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" 
                                role="button" data-toggle="dropdown" aria-haspopup="true" 
                                aria-expanded="false" v-pre>
                                {{ session('nama') }} <sub>{{ session('level') }}</sub> <span class="caret"> </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{url('/users/ganti_password')}}">
                                        <i class="fa fa-user pull-right"></i>
                                        Ganti Password</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('/users/my_profile')}}">
                                        <i class="fa fa-user pull-right"></i>
                                        Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('/logout')}}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out pull-right"></i>
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/otentikasi/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>

                            </ul>
                        </li>

                        <?php session(['LAST_ACTIVITY'=>time()]); ?>
                    @endif
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
