<?php 
	
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";

	$train_no='';
	$num_pass='';
	$date ='';
	$error="";
 	// Check if the user is logged in, if not then redirect him to login page
	// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	// 	header("location: login.php");
	// 	exit;
	// }

 	if(isset($_POST['submit'])){
 		//echo "CHECK\ndate = $date\ntrain_number = $train_no\nnumber of passengers = $num_pass\n";
 		$date 		= mysqli_real_escape_string($link,trim($_POST['doj']));
 		$train_no 	= mysqli_real_escape_string($link,trim($_POST['train_no']));
 		$num_pass	= mysqli_real_escape_string($link,trim($_POST['no_of_passengers']));
 		//query will take input from user about trainno and date and no_of_passengers and 
 		//return a table entry iff it had cummulative reaminging number of seats in either of the category AC or Sleeper class
 		$sql = "SELECT * FROM booking_system where booking_system.trainno = $train_no and booking_system.date = '$date' and ((18*ac_coaches)-ac_seats>=$num_pass or (24*sl_coaches)-sl_seats>=$num_pass);";
 		$result=mysqli_query($link, $sql);
     
 		//echo "CHECK\ndate = $date\ntrain_number = $train_no\nnumber of passengers = $num_pass\n";
 		if(mysqli_num_rows($result)==0){
       $error="No Train found";
 		}
 		else{
       $train_found=mysqli_fetch_row($result);
       print_r($train_found);
       $_SESSION['trainno']=$train_found[0];
       $_SESSION['ac_coaches']=$train_found[2];
       $_SESSION['sl_coaches']=$train_found[3];
       $_SESSION['ac_seats']=$train_found[4];
       $_SESSION['sl_seats']=$train_found[5];
      $_SESSION['date']=$date;
      $_SESSION['num_pass']=$num_pass;
      print_r($_SESSION);
      header("location: available_trains.php");
 			//echo "query error : ".mysqli_error($link);
 		}

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
    <h2><?php echo $error ?></h2>
  	<h3>Select your travelling date</h3>
  	<form class="form_class" action="" method="POST">
  	<div class="form-group">
		<label>Choose Your Date of Journey</label>
		<input type="date" name="doj" class="form-control" value="" min="<?php echo date("Y-m-d") ?>">
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
	

	<div class="form-group">
		<input type="submit" name="submit" class="btn btn-primary" value="Submit">
  	</div>  
	
</div>
</form>
</div>
<?php include('footer.php'); ?>