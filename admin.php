<?php session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
     exit;
 }
 require_once "config.php";
 $sql1 = 'SELECT trainno,name FROM trains';
$result = mysqli_query($link, $sql1);

	// fetch the resulting rows as an array
	$trains = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// free the $result from memory (good practise)
	mysqli_free_result($result);
	//mysqli_close($conn);

 $ac_seats=0;
 $sl_seats=0;
 $date ='';
 $release='';
 $train =0;
 $no_of_ac_coaches=0;
 $no_of_sl_coaches=0;
 $errors = array('date' => '', 'train' => '', 'no_of_ac_coaches' => '', 'no_of_sl_coaches'=>'');

 if(isset($_POST['submit'])){
     
     // check email
     if(empty($_POST['dor'])){
         $errors['date'] = 'Date is required';
     } else{
        $rawdate = htmlentities($_POST['dor']);
        $date = date('Y-m-d', strtotime($rawdate));
         //$date = $_POST['dor'];
         echo $date;
     }

     // check title
     if(empty($_POST['train'])){
         $errors['train'] = 'Train is not selected';
     } else{
         $train = $_POST['train'];
         echo $train;
     }

     // check ingredients
     if(!isset($_POST['no_of_ac_coaches'])){
         $errors['no_of_ac_coaches'] = 'Number of AC coaches not given';
     } else{
         $no_of_ac_coaches = $_POST['no_of_ac_coaches'];
         echo $no_of_ac_coaches;
     }
     if(!isset($_POST['no_of_sl_coaches'])){
        $errors['no_of_sl_coaches'] = 'Number of sleeper coaches not given';
    } else{
        $no_of_sl_coaches = $_POST['no_of_sl_coaches'];
        echo $no_of_sl_coaches;
    }

    if(array_filter($errors)){
         echo 'errors in form';
     } else {
         // escape sql chars
         $ac_seats=$no_of_ac_coaches*18;
         $sl_seats=$no_of_sl_coaches*24;
         $date = mysqli_real_escape_string($link, $_POST['dor']);
         $train = mysqli_real_escape_string($link, $_POST['train']);
         $no_of_ac_coaches = mysqli_real_escape_string($link, $_POST['no_of_ac_coaches']);
         $no_of_sl_coaches = mysqli_real_escape_string($link, $_POST['no_of_sl_coaches']);

         // create sql
         $sql = "INSERT INTO booking_system(trainno,date,ac_coaches,sl_coaches,ac_seats,sl_seats) VALUES($train,'$date',$no_of_ac_coaches,$no_of_sl_coaches,0,0)";

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
 ?>
 </head>
    <style type="text/css">
    .form-group{
        padding-left:35%;
        padding-right:35%;
    }
    </style>
</head>
<?php include('header.php'); ?>
<div class="text-center">
  <h3><?php echo $release ?></h3>  
  <h3>Release Train</h3>
  <form class="form_class" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <div class="form-group">
    <label>Train Name</label>
    <select name="train" id="train" class="form-control">
        <option selected>Choose...</option>
        <?php foreach($trains as $train): ?>
        <option value=<?php echo $train['trainno'] ?>><?php echo $train['name']."(".$train['trainno'].")" ?></option>
        <?php endforeach; ?>
      </select>
      <small id="emailHelp" class="form-text text-muted"><?php echo  $errors['train'] ?></small>
  </div>
  <div class="form-group">
    <label>Choose Your Date of Release</label>
    <input type="date" name="dor" class="form-control" value="" min="<?php echo date("Y-m-d") ?>">
    <small id="emailHelp" class="form-text text-muted"><?php echo  $errors['date'] ?></small>
  </div>
  <div class="form-group">
    <label>Number of AC coaches</label>
    <input type="number" name="no_of_ac_coaches" class="form-control" value="0">
    <small id="emailHelp" class="form-text text-muted"><?php echo  $errors['no_of_ac_coaches'] ?></small>
  </div>
  <div class="form-group">
    <label>Number of sleeper coaches</label>
    <input type="number" name="no_of_sl_coaches" class="form-control" value="0">
    <small id="emailHelp" class="form-text text-muted"><?php echo  $errors['no_of_sl_coaches'] ?></small>
  </div>
  <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</div>
</form>
</div>
<?php include('footer.php'); ?>