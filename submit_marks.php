<head>
	<title>Submit Marks</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<?php session_start(); if(isset($_SESSION['firstname_webtech']) == false){echo header('location:index.php');} ?>
	<?php 
		$connect; $result; $rows;
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
		function retrieve_data()
		{
			$query = "SELECT * FROM course_marks GROUP BY student_id";
			global $connect, $result, $rows;

			$result = mysqli_query($connect,$query);
			
		}
		connect_to_db();retrieve_data();
	?>
<div class="text-center py-2">
	<a class="text-danger float-right mr-2" href="logout.php">Log Out</a>
	<h1>Hello <?php echo $_SESSION['firstname_webtech']; ?>.  Marks Submissions and Results</h1>
</div>
<div class="container">
  <div class="card">
  	<form class="form-group" method="POST" action="submit_marks_backend.php">
    	<div class="card-header">
    		Submit Marks
    	</div>
    	<div class="card-body">
    		<div class="container-fluid">
    			<div class="row">
    				<div class="col-md-4">
    					<label>Student Name</label>
    					<input class="form-control" type="text" name="student_name">    					
    				</div>
    				<div class="col-md-4">
    					<label>Student ID</label>
    					<input class="form-control" type="text" name="student_id">
    					<input class="form-control" type="hidden" value=<?php echo $_SESSION['id_webtech']; ?> name="teacher_id">
    				</div>
    				<div class="col-md-4">
    					<label>Course Name and ID</label>
    					<select class="form-control" type="text" name="course_id">
    						<option value="1">Web Technology and Internet Computing (MIT001)</option>
    						<option value="2">Cryptography and Network Security (MIT002)</option>
    						<option value="3">Software Project Management (MIT003)</option>
    					</select>
    				</div>
    				<div class="col-md-6">
    					<label>Class Test Marks</label>
    					<input class="form-control" type="number" max="40" name="class_test">
    				</div>
    				<div class="col-md-6">
    					<label>Final Term Marks</label>
    					<input class="form-control" type="number" max="60" name="final_term">
    				</div>
    			</div>
    		</div>
    	</div> 
    	<div class="card-footer text-right">
    		<button class="btn btn-success">
    			Submit
    		</button>
    	</div>
  	</form>
  </div>
</div>

<div class="container my-4">
  <div class="card">
  	<form class="form-group">
    	<div class="card-header">
    		Results
    	</div>
    	<div class="card-body">
    		<table class="table">
    			<thead>
    				<th>Student ID</th>
    				<th>Course ID</th>
    				<th>Final Result</th>
    				<th>Action</th>
    			</thead>
    			<tbody>
    				<?php 
    				$i = 0; $student_arr = []; $course_arr = [];
    					while($row = mysqli_fetch_assoc($result))
    					{ 
    						$student_id = $row['student_id'];
    						$course_id = $row['course_id'];

    						if(in_array($student_id, $student_arr) and in_array($course_id, $course_arr))
    						{

    						}
    						else
    						{
    							$total_marks = 0;
    							$marks_query = "SELECT (class_test+final_term) as t_m FROM course_marks WHERE student_id = $student_id AND course_id = $course_id";
    							$teacher_marks = []; $n = 0;
    							$marks_result = mysqli_query($connect,$marks_query);
    							while($rowm = mysqli_fetch_assoc($marks_result))
    							{
    								$teacher_marks[$n] = $rowm['t_m'];
    								$n++;
    							}
    							$course_query = "SELECT sum(class_test) as class_test_total, sum(final_term) as final_term_total FROM course_marks WHERE student_id = $student_id AND course_id = '$course_id' GROUP BY student_id ";
    							$course_result = mysqli_query($connect,$course_query);
    							while($rowc = mysqli_fetch_assoc($course_result))
    							{
    								$class_test_total = $rowc['class_test_total'];
    								$final_term_total = $rowc['final_term_total'];

    								$total_marks = $total_marks + $class_test_total + $final_term_total;
    								$student_arr[$i] = $student_id; 
    								$course_arr[$i] = $course_id; 
    							
    								$i++;
    							}
    							$avg_marks = $total_marks/2; 

    							$first_num_diff = $avg_marks - $teacher_marks[0];
    							$second_num_diff = $avg_marks - $teacher_marks[1];
    								if($first_num_diff < 0)
    								{
    									$first_num_diff = $first_num_diff * (-1);
    								}
    								if($second_num_diff < 0)
    								{
    									$second_num_diff = $second_num_diff * (-1);
    								}
    								$deviation1 = ($first_num_diff / $teacher_marks[0])*100;
    								$deviation2 = ($second_num_diff / $teacher_marks[1])*100;

    								if($deviation1 > 20 or $deviation2 > 20)
    								{
    									$deviation_flag = true;
    								}
    								else
    								{
    									$deviation_flag = false;
    								}
    							?>						
    				<tr>
    					<td><?php echo $student_id; ?></td>
    					<td><?php if($course_id == 1){echo 'MIT001';}else if($course_id == 2){echo 'MIT002';} else if($course_id == 3){echo 'MIT003';} ?></td>
    					<td><?php if($deviation_flag == true){echo "Marks deviated more than 20%. Result will not generate.";}else{echo $total_marks/2;} ?></td>
    					<td><button type="button" id="btn_set_values" class="btn-sm btn-success" data-toggle="modal" data-target="#exampleModalCenter" data-student-id = <?php echo $student_id; ?> data-course-id = <?php echo $course_id; ?> data-teacher-id = <?php echo $course_id; ?> onclick="set_values();">Submit Marks</button></td>
    				</tr>
    				<?php
    						}
    				 	} 
    				?>
    			</tbody>
    		</table>
    	</div> 
    	<div class="card-footer text-right">
    	</div>
  	</form>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  		<form class="form-group" method="POST" action="submit_marks_backend.php">
        <input id="id_course" type="hidden" name="course_id">
        <input id="id_teacher" type="hidden" name="teacher_id">
        <input id="id_student" type="hidden" name="student_id">
        <label>Class Test Marks</label>
        <input class="form-control" id="id_cls_marks" type="number" name="class_test">
        <label>Final Term Marks</label>
        <input class="form-control" id="id_final_marks" type="number" name="final_term">
        <button type="submit" class="btn btn-primary my-2">Submit Marks</button>
  		</form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
</script>
<script type="text/javascript">
	function set_values()
	{
		$('#id_course').val($('#btn_set_values').attr('data-course-id'));
		$('#id_teacher').val($('#btn_set_values').attr('data-teacher-id'));
		$('#id_student').val($('#btn_set_values').attr('data-student-id'));
	}

</script>
</body>