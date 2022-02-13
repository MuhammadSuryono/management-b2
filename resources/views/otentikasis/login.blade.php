@extends('auth_gentelella')

@section('content')
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">

            @if (session('status'))
            <div class="x_content bs-example-popovers">
                <div align="center" class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{url('/otentikasi/cek_login')}}">
                    @csrf
                    <div>
                        <img width="100%" src="{{url('../assets/')}}/images/logo_mri_full.png" alt="" />
                    </div>
                    <h1 style="background-color:Purple; color:Gold; padding:8px">Project Management System </h1>
                    <h2 style="background-color:Blue; color:Gold; padding:8px">Unit Business 2</h2>
                    <h1>Login Form</h1>
                    <div>
                        <input id="user_login" type="text" value="" class="form-control
                @error('user_login') is-invalid @enderror" name="user_login" placeholder="Username" value="{{ old('user_login') }}" required autofocus>
                        @error('user_login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <input id="password" type="password" value="" class="form-control
                @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-info submit">Log in</button>
                        {{-- <a class="reset_pass" href="{{url('/otentikasi/email_reset_password')}}">Reset Password</a> --}}
                    </div>

                    <div class="clearfix"></div>
                    <div class="separator">
                        <script src="{{url('../assets/gentelella')}}/vendors/jquery/dist/jquery.min.js"></script>
                        <strong>Copyright &copy; {{date('Y')}}</strong> <a href="https://www.mri-research-ind.com">Marketing Research Indonesia</a>
                    </div>
            </div>
            </form>
        </section>
    </div>
</div>
@endsection
