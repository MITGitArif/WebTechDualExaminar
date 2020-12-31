<?php
	
	$firstname; $lastname; $phone; $username; $password;
	$connect;
	function validate()
	{
		if(isset($_POST['firstname']) and empty($_POST['firstname']) == false)
		{
			global $firstname;
			$firstname = $_POST['firstname'];
		}
		else
		{
			echo "First Name is Required";
			return;
		}
		if(isset($_POST['lastname']) and empty($_POST['lastname']) == false)
		{
			global $lastname;
			$lastname = $_POST['lastname'];		
		}
		else
		{
			echo "Last Name is Required";
			return;
		}
		if(isset($_POST['phone']) and empty($_POST['phone']) == false)
		{
			global $phone;
			$phone = $_POST['phone'];
		}
		else
		{
			echo "Phone Number is Required";
			return;
		}
		if(isset($_POST['username']) and empty($_POST['username']) == false)
		{
			global $username;
			$username = $_POST['username'];
		}
		else
		{
			echo "Username is Required";
			return;
		}
		if(isset($_POST['password']) and empty($_POST['password']) == false)
		{
			global $password;
			$password = $_POST['password'];

				if($_POST['password'] != $_POST['confirm_password'])
				{
					echo "Passwords don't match";
					return;
				}
				else
				{
					$password = hash('sha512', $password);
				}
		}
		else
		{
			echo "Password is Required";
			return;
		}
	}
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
	function insert_into_db()
	{
		global $firstname, $lastname, $username, $phone, $password;
		global $connect;

		$sql = "INSERT INTO teachers VALUES(' ','$firstname','$lastname','$username','$password','$phone')";

		if(mysqli_query($connect, $sql))
		{
			echo "<div width='100%' style='color:grey;font-size:42px;text-align:center'>Successfully Registered "."<a href='index.php'>Log In</a></div>";
		}
		else
		{
			echo "Something Went Wrong ".mysqli_error($connect);
		}
	} 
	validate();
	connect_to_db();
	insert_into_db();
	?>