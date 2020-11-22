<?php session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
 }
 $no_of_passengers=5;
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
<div class="container">
<div class="text-center">
  <h2>Input Passenger Information</h2>
  <form>
  <?php for ($x = 1; $x <= $no_of_passengers; $x++){ ?>
  <h4>Passenger <?php echo $x ?></h4>
    <div class="form-row">
    <div class="form-group col-md-6">
      <label>Name</label>
      <input type="text" class="form-control" id="name">
    </div>
    <div class="form-group col-md-4">
      <label>Gender</label>
      <select id="gender" class="form-control">
        <option selected>Choose...</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label>Age</label>
      <input type="number" class="form-control" id="age">
    </div>
  </div>
  <?php } ?>
</form>
</div>
</div>