<?php
	
	$course_id; $student_name; $student_id; $teacher_id; $class_test; $final_term;
	$connect;
	
	function take_inputs()
	{
		global  $student_name, $course_id, $student_id, $teacher_id, $class_test, $final_term;

		$course_id = $_POST['course_id'];
		if(isset($_POST['student_name']))
		{
			$student_name = $_POST['student_name'];
		}
		else
		{
			$student_name = null;
		}
		$student_id = $_POST['student_id'];
		$teacher_id = $_POST['teacher_id'];
		$class_test = $_POST['class_test'];
		$final_term = $_POST['final_term'];
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
		global $course_id, $student_name, $student_id, $teacher_id, $class_test, $final_term;
		global $connect;

		$sql1 = "INSERT INTO students VALUES(' ','$student_id','$student_name')";
		$sql2 = "INSERT INTO course_marks VALUES(' ','$course_id','$student_id','$teacher_id','$class_test','$final_term')";

		if(mysqli_query($connect, $sql1))
		{
		
			if(mysqli_query($connect, $sql2))
			{
				echo "<div width='100%' style='color:grey;font-size:42px;text-align:center'>Successfully Inserted "."<a href='submit_marks.php'>Continue</a></div>";
			}
			else
			{
				echo "Something Went Wrong ".mysqli_error($connect);
			}
		}
		else
		{
			echo "Something Went Wrong ".mysqli_error($connect);
		}
	} 
	take_inputs();
	connect_to_db();
	insert_into_db();
	?>