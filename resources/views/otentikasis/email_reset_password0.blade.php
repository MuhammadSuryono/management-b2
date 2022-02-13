<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/assets/images/logo_<?php echo strtolower($_SESSION['nama_gereja_singkat']);?>.png">

	<title><?php echo $_SESSION['nama_gereja_full'] ; ?> | </title>

	<!-- Bootstrap -->
	<link href="/assets/gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css"
		rel="stylesheet">
	<!-- Font Awesome -->
	<link href="/assets/gentelella-master/vendors/font-awesome/css/font-awesome.min.css"
		rel="stylesheet">
	<!-- NProgress -->
	<link href="/assets/gentelella-master/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="/assets/gentelella-master/vendors/animate.css/animate.min.css"
		rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="/assets/gentelella-master/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<div>
						<img width="100%" src="{{url('../assets/')}}/images/logo_mri_full.png" alt="" />
					</div>111
					{{-- <?php echo validation_errors(); ?> --}}
					{{-- <?php echo form_open(); ?> --}}
					<form method="POST" action="{{url('/otentikasi/send_reset_password')}}">
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
</body>

</html>
