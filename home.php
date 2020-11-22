<?php session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
     exit;
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
  <form class="form_class" action="" method="">
  <div class="form-group">
    <label>Choose Your Date of Journey</label>
    <input type="date" name="doj" class="form-control" value="">
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