@extends('auth_gentelella')

@section('content')
<div>
	<a class="hiddenanchor" id="signup"></a>
	<a class="hiddenanchor" id="signin"></a>

	<div class="login_wrapper">
		<div class="animate form login_form">
			<section class="login_content">
				<div>
					<img width="100%" src="{{url('../assets/')}}/images/logo_mri_full.png" alt="" />
				</div>
				@error('email')
					<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
					</span>
				@enderror
				<form method="POST" action="{{url('/otentikasi/send_reset_password')}}">
					@csrf
				<h1>Reset Password</h1>
				<p>Please enter your email to reset or change your password </p>
				<div>
					<input type="email" class="form-control" id="email" name="email" placeholder="Email"
						required="" />
				</div>
				<div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<!-- <a class="reset_pass" href="#">Lost your password?</a> -->
				</div>
				</form>
			</section>
		</div>
	</div>
</div>

@endsection
