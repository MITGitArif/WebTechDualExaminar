<?php
$connect;
	function connect_to_db()
	{
		$servername = "localhost";
		$username = "root";
		$password = "";
		$db_name = "result_submission_db";

		global $connect;
		$connect = mysqli_connect($servername,$username,$password,$db_name);

		if(!$connect)
		{
			echo "Connection Failed";
		}
	}
	function log_in()
	{
		global $connect;
		$username = $_POST['username']; $password = hash('sha512',$_POST['password']);

		$sql = "SELECT * FROM teachers WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($connect,$sql);
		$count = mysqli_num_rows($result);

		if($count == 1)
		{
			$rows = mysqli_fetch_assoc($result);

			session_start();

			$_SESSION['id_webtech'] = $rows['id'];
			$_SESSION['firstname_webtech'] = $rows['first_name'];
			$_SESSION['lastname_webtech'] = $rows['last_name'];
			$_SESSION['username_webtech'] = $rows['username'];
			$_SESSION['password_webtech'] = $rows['password'];
			header('location:submit_marks.php');
		}
	}

	connect_to_db();
	log_in();
?>