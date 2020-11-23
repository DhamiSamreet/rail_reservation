<?php 
	
	include('config.php');

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
	}

	$query = "INSERT INTO trains(trainno,name,from_station,to_station) VALUES ('$train_no','$train_name','$from_st','$to_st');";
	if(mysqli_query($link,$query)){
		//continue, successful
	}
	else{
		echo "query error : ".mysqli_error($link);
	}

 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>Add a new train</title>
 	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style type="text/css">
    .form-group{
        padding-left:35%;
        padding-right:35%;
        padding-top:-5%;
    }
    </style>
 </head>
 <body>
 	<?php //include('header.php'); ?>
 	<section>
 		<form method = "POST">
 			<label>Train No.</label>
 			<input type="text" name="trainno">
 			<br>
 			<label>Train Name</label>
 			<input type="text" name="name">
 			<br>
 			<label>Source</label>
 			<input type="text" name="fromSt">
 			<br>
 			<label>Destination</label>
 			<input type="text" name="toSt">
 			<div>
 				<input type="submit" name="submit" value="submit">
 			</div>
 		</form>
 	</section>
 </body>
 </html> 