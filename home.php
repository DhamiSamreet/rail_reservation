<?php 
	
	session_start();
	include('config.php');

	$trainno='';
	$num_pass='';
	$date ='';
	$res="";
 	// Check if the user is logged in, if not then redirect him to login page
	// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	// 	header("location: login.php");
	// 	exit;
	// }

 	if(isset($_POST["submit"])){
 		echo "CHECK\ndate = $date\ntrain_number = $train_no\nnumber of passengers = $num_pass\n";
 		$date 		= mysqli_real_escape_string($link,trim($_POST['doj']));
 		$train_no 	= mysqli_real_escape_string($link,trim($_POST['train_no']));
 		$num_pass	= mysqli_real_escape_string($link,trim($_POST['no_of_passengers']));
 		//query will take input from user about trainno and date and no_of_passengers and 
 		//return a table entry iff it had cummulative reaminging number of seats in either of the category AC or Sleeper class
 		$sql = "SELECT * FROM booking_system where booking_system.trainno = $trainno and booking_system.date = $date and ((18*ac_coaches)-ac_seats>=$num_pass or (24*sl_coaches)-sl_seats>=$num_pass)";
 		$result="";
 		
 		echo "CHECK\ndate = $date\ntrain_number = $train_no\nnumber of passengers = $num_pass\n";
 		if($result=mysqli_query($link, $sql)){
 			$result=mysqli_query($link, $sql);
 			echo "QUERY RAN SUCCESSFULLY!!\n";
 			print_r($result);
 		}
 		else{
 			echo "query error : ".mysqli_error($link);
 		}

 	}
 	else{
 		//some error in giving input for searching trains
 		echo "submit not set\n";
 	}

 ?>
 

 <head>
 <style type="text/css">
	.form-group{
		padding-left:35%;
		padding-right:35%;
	}
	</style>
</head>
<?php include('header.php'); ?>
<div class="text-center">
  	<h2>Select your travelling date</h2>
  	<form class="form_class" action="" method="POST">
  	<div class="form-group">
		<label>Choose Your Date of Journey</label>
		<input type="date" name="doj" class="form-control" value="">
		<small id="emailHelp" class="form-text text-muted">something can be printed</small>
  	</div>
  	<div class="form-group">
		<label>Train number</label>
		<input type="number" name="train_no" class="form-control" value="">
		<small id="emailHelp" class="form-text text-muted">something can be printed</small>
  	</div>
  	<div class="form-group">
		<label>Number of Passengers</label>
		<input type="number" name="no_of_passengers" class="form-control" value="">
		<small id="emailHelp" class="form-text text-muted">something can be printed</small>
  	</div>
  
	<button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
