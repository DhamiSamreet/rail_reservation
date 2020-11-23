<?php session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
 }
 $no_of_passengers=$_SESSION['num_pass'];
 if(isset($_POST['submit'])){
    for ($x = 1; $x <= $no_of_passengers; $x++){
    echo $_POST['name'.$x];
    echo $_POST['gender'.$x];
    echo $_POST['age'.$x];
    //echo print_r($_POST);
    // check email

    // check title
    if(empty($_POST['name'.$x])){
        $errors['train'] = 'Train is not selected';
    } else{
        $train = $_POST['train'];
        echo $train;
    }

    // check ingredients
    if(empty($_POST['no_of_ac_coaches'])){
        $errors['no_of_ac_coaches'] = 'Number of AC coaches not given';
    } else{
        $no_of_ac_coaches = $_POST['no_of_ac_coaches'];
        echo $no_of_ac_coaches;
    }
    if(empty($_POST['no_of_sl_coaches'])){
       $errors['no_of_sl_coaches'] = 'Number of sleeper coaches not given';
   } else{
       $no_of_sl_coaches = $_POST['no_of_sl_coaches'];
       echo $no_of_sl_coaches;
   }

   if(array_filter($errors)){
        echo 'errors in form';
    } else {
        // escape sql chars
        $ac_seats-$no_of_ac_coaches*18;
        $sl_seats=$no_of_sl_coaches*24;
        $date = mysqli_real_escape_string($link, $_POST['dor']);
        $train = mysqli_real_escape_string($link, $_POST['train']);
        $no_of_ac_coaches = mysqli_real_escape_string($link, $_POST['no_of_ac_coaches']);
        $no_of_sl_coaches = mysqli_real_escape_string($link, $_POST['no_of_sl_coaches']);

        // create sql
        $sql = "INSERT INTO booking_system(trainno,date,ac_coaches,sl_coaches,ac_seats,sl_seats) VALUES($train,'$date',$no_of_ac_coaches,$no_of_sl_coaches,$ac_seats,$sl_seats)";

        // save to db and check
        if(mysqli_query($link, $sql)){
            echo "Train released successfully";
            $release="Train released successfully";
            //header('Location: .php');
        } else {
            echo 'query error: '. mysqli_error($link);
        }
    }

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
<div class="container">
<div class="text-center">
  <h2>Input Passenger Information</h2>
  <form class="form_class" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <?php for ($x = 1; $x <= $no_of_passengers; $x++){ ?>
  <h4>Passenger <?php echo $x ?></h4>
    <div class="form-row">
    <div class="form-group col-md-6">
      <label>Name</label>
      <input type="text" class="form-control" id=<?php echo "name".$x ?> name=<?php echo "name".$x ?>>
    </div>
    <div class="form-group col-md-4">
      <label>Gender</label>
      <select id=<?php echo "gender".$x ?> name=<?php echo "gender".$x ?> class="form-control">
        <option selected>Choose...</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label>Age</label>
      <input type="number" class="form-control" id=<?php echo "age".$x ?> name=<?php echo "age".$x ?>>
    </div>
  </div>
  <?php } ?>
  <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</form>
</div>
</div>