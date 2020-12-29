<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="text-center py-2">
		<h1>Result Submission for Dual Examinar</h1>
	</div>
	<div class="container-fluid my-5">
		<div class="row">
			<div class="col-md-6 offset-3">
				<div class="container-fluid border border-secondary rounded py-4">
					<form class="form-group" method="POST" action="register_backend.php">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Teacher Registration</h4>
							</div>
							<div class="col-md-12">
								<label>First Name</label>
								<input class="form-control" type="text" name="firstname">
							</div>
							<div class="col-md-12 my-2">
								<label>Last Name</label>
								<input class="form-control" type="text" name="lastname">
							</div>							
							<div class="col-md-12 my-2">
								<label>Phone Number</label>
								<input class="form-control" type="text" name="phone">
							</div>
							<div class="col-md-12 my-2">
								<label>Username</label>
								<input class="form-control" type="text" name="username">
							</div>
							<div class="col-md-12 my-2">
								<label>Password</label>
								<input class="form-control" type="password" name="password">
							</div>
							<div class="col-md-12 my-2">
								<label>Confirm Password</label>
								<input class="form-control" type="password" name="confirm_password">
							</div>
							<div class="col-md-12 my-2">
								<input class="btn btn-success form-control" type="submit">
							</div>
							<div class="col-md-12 my-2 text-center text-success">
								<label>or</label>
								<a class="text-success h6" href="index.php">				
									Log In
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>