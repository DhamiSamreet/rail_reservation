<?php session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
     exit;
 }
 print_r($_SESSION);
 if(isset($_POST['ac'])){
    echo "Oh yeahhh!!";
    $_SESSION['type']='ac';
    header("location: passenger_info.php");
 }
 elseif(isset($_POST['sl'])){
     $_SESSION['type']='sl';
     header("location: passenger_info.php");
 }
 ?>
<?php include('header.php'); ?>
<div class="container">
<div class="text-center">
<h1 alignment="center"> Train Number: <?php echo $_SESSION['trainno'] ?></h1>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    AC   seats
    <span class="badge badge-primary badge-pill">  Seats left:<?php echo 18*$_SESSION['ac_coaches']-$_SESSION['ac_seats'] ?></span>
    <?php if((18*$_SESSION['ac_coaches']-$_SESSION['ac_seats'])<$_SESSION['num_pass']){ ?>
    <span class="badge badge-primary badge-pill">Cannot Book</span>
    <?php }else{ ?>
        <span><form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"><input type="submit" name="ac" value="Book" class="btn btn-primary"></form></span>
    <?php } ?>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Sleeper seats
    <span class="badge badge-primary badge-pill">Seats left: <?php echo 24*$_SESSION['sl_coaches']-$_SESSION['sl_seats'] ?></span>
    <?php if((24*$_SESSION['sl_coaches']-$_SESSION['sl_seats'])<$_SESSION['num_pass']){ ?>
    <span class="badge badge-primary badge-pill">Cannot Book</span>
    <?php }else{ ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"><input type="submit" name="sl" value="Book" class="btn btn-primary"></form>
    <?php } ?>
  </li>
</ul>
</div>
</div>
<?php include('footer.php'); ?>