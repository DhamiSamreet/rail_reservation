<?php 
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login.php");
		exit;
	}
	require_once "config.php";
	$train_no="";
	$train_name="";
	$from_st="";
	$to_st = "";



	if(isset($_POST['submit'])){
		$train_no 		= mysqli_real_escape_string($link,trim($_POST['trainno']));
		$train_name 	= mysqli_real_escape_string($link,trim($_POST['name']));
		$from_st 		= mysqli_real_escape_string($link,trim($_POST["fromSt"]));
		$to_st 			= mysqli_real_escape_string($link,trim($_POST["toSt"]));
		// echo "$train_no\n$train_name\n$from_st\n$to_st\n";

	$query = "INSERT INTO trains(trainno,name,from_station,to_station) VALUES ('$train_no','$train_name','$from_st','$to_st');";
	if(mysqli_query($link,$query)){
		//continue, successful
	}
	else{
		echo "query error : ".mysqli_error($link);
	}
}

 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>Add a new train</title>
    <style type="text/css">
    .form-group{
        padding-left:35%;
        padding-right:35%;
        padding-top:-5%;
    }
    </style>
 </head>
 <body>
 	<?php include('header.php'); ?>
 	<section>
	 <div class="text-center">
	 <form class="form_class" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	 <div class="form-group">
 			<label>Train No.</label>
 			<input type="text" name="trainno" class="form-control">
 	</div>
	 <div class="form-group">
 			<label>Train Name</label>
 			<input type="text" name="name" class="form-control">
 	</div>
	 <div class="form-group">
 			<label>Source</label>
 			<input type="text" name="fromSt" class="form-control">
 	</div>
	 <div class="form-group">
 			<label>Destination</label>
 			<input type="text" name="toSt" class="form-control">
			 </div>
 			<div>
 				<input type="submit" name="submit" value="Submit" class="btn btn-primary">
 			</div>
 		</form>
	</div>
 	</section>
 </body>
 </html> 