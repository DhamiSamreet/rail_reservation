<?php session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
 }
 require_once "config.php";
 $no_of_passengers=$_SESSION['num_pass'];
 $check=TRUE;
 $errors = array('name' => '', 'age' => '', 'gender' => '', 'pid'=>'');
 if(isset($_POST['submit'])){
    for ($x = 1; $x <= $no_of_passengers; $x++){
    echo $_POST['name'.$x];
    echo $_POST['gender'.$x];
    echo $_POST['age'.$x];
    echo $_POST['pid'.$x];
    //echo print_r($_POST);
    // check email
    
    // check title
    if(empty($_POST['name'.$x])){
        $errors['name'] = 'All names are not entered';
    } 
    if(empty($_POST['age'.$x])){
        $errors['age'] = 'Age of all passengers not entered';
    } 
    if(empty($_POST['gender'.$x])){
       $errors['gender'] = 'Please choose gender of all the passengers';
   } 
   if(empty($_POST['pid'.$x])){
    $errors['pid'] = 'All IDs are not entered';
} 
}
function berthtypeac(int $num){
    if($num%6==1 || $num%6==2){
        return "LB";
    }
    elseif($num%6==3 || $num%6==4){
        return "UB";
    }
    elseif($num%6==5){
        return "SL";
    }
    else{
        return "SU";
    }
}
function berthtypesl(int $num){
    if($num%8==1 || $num%8==4){
        return "LB";
    }
    elseif($num%8==2 || $num%8==5){
        return "MB";
    }
    elseif($num%8==3 || $num%8==6){
        return "UB";
    }
    elseif($num%8==7){
        return "SL";
    }
    else{
        return "SU";
    }
}
    if(array_filter($errors)){
        echo 'errors in form';
    } else {
        // escape sql chars
        $sql = "SELECT COUNT(*) as total FROM tickets";
        $result=mysqli_query($link, $sql);
        $data=mysqli_fetch_assoc($result);
        $pnr=$data['total']+100001;
        $_SESSION['pnr']=$pnr;
        if(strcmp($_SESSION['type'],'ac')==0){
            $ac_seats=$_SESSION['ac_seats'];
            $date=$_SESSION['date'];
            $trainno=$_SESSION['trainno'];
            $id=$_SESSION['id'];
            $sql1="INSERT INTO tickets(pnr,trainno,doj,coach_type,num_pass,booked_by) VALUES($pnr,$trainno,'$date','ac',$no_of_passengers,$id)";
            if(mysqli_query($link, $sql1)){
                echo "Ticket Made";
                for ($x = 1; $x <= $no_of_passengers; $x++){
                    $ac_seats++;
                    $coachno=(int)($ac_seats/18);
                    $coachno++;
                    $berthno=($ac_seats%18);
                    $berthtype=berthtypeac($berthno);
                    $name = mysqli_real_escape_string($link, $_POST['name'.$x]);
                    $age = mysqli_real_escape_string($link, $_POST['age'.$x]);
                    $gender = mysqli_real_escape_string($link, $_POST['gender'.$x]);
                    $pid= mysqli_real_escape_string($link, $_POST['pid'.$x]);
                    $coach="AC".$coachno;
                    $sql = "CALL insertPass(?,?,?,?,?,?,?,?)";
                    $call = mysqli_prepare($link, $sql);
                    mysqli_stmt_bind_param($call, 'iissisis', $pid,$pnr,$name,$gender,$age,$coach,$berthno,$berthtype);
                    if(mysqli_stmt_execute($call)){
                        echo "Query successful";
                        //header('Location: .php');
                    } else {
                        echo 'query error: '. mysqli_error($link);
                        $check=FALSE;
                    }
                }
            } else {
                echo 'query error: '. mysqli_error($link);
                $check=FALSE;
            }
        }
        else{
            $sl_seats=$_SESSION['sl_seats'];
            $date=$_SESSION['date'];
            $trainno=$_SESSION['trainno'];
            $id=$_SESSION['id'];
            $sql1="INSERT INTO tickets(pnr,trainno,doj,coach_type,num_pass,booked_by) VALUES($pnr,$trainno,'$date','sl',$no_of_passengers,$id)";
            if(mysqli_query($link, $sql1)){
                echo "Ticket Made";
                for ($x = 1; $x <= $no_of_passengers; $x++){
                    $sl_seats++;
                    $coachno=(int)($sl_seats/24);
                    $coachno++;
                    $berthno=($sl_seats%24);
                    $berthtype=berthtypesl($berthno);
                    $name = mysqli_real_escape_string($link, $_POST['name'.$x]);
                    $age = mysqli_real_escape_string($link, $_POST['age'.$x]);
                    $gender = mysqli_real_escape_string($link, $_POST['gender'.$x]);
                    $pid= mysqli_real_escape_string($link, $_POST['pid'.$x]);
                    $coach="SL".$coachno;
                    $sql = "CALL insertPass(?,?,?,?,?,?,?,?)";
                    $call = mysqli_prepare($link, $sql);
                    mysqli_stmt_bind_param($call, 'iissisis', $pid,$pnr,$name,$gender,$age,$coach,$berthno,$berthtype);
                    if(mysqli_stmt_execute($call)){
                        echo "Query successful";
                        //header('Location: .php');
                    } else {
                        echo 'query error: '. mysqli_error($link);
                        $check=FALSE;
                    }
                }
            }
            else{
                echo 'query error: '. mysqli_error($link);
                $check=FALSE;
            }
        }
        if($check){
            header('location: ticket.php');
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
  <h2 class="display-4">Input Passenger Information</h2>
  <form class="form_class" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <?php for ($x = 1; $x <= $no_of_passengers; $x++){ ?>
  <h4>Passenger <?php echo $x ?></h4>
    <div class="form-row">
    <div class="form-group col-md-2">
      <label>ID</label>
      <input type="number" class="form-control" id=<?php echo "pid".$x ?> name=<?php echo "pid".$x ?>>
    </div>
    <div class="form-group col-md-6">
      <label>Name</label>
      <input type="text" class="form-control" id=<?php echo "name".$x ?> name=<?php echo "name".$x ?>>
    </div>
    <div class="form-group col-md-3">
      <label>Gender</label>
      <select id=<?php echo "gender".$x ?> name=<?php echo "gender".$x ?> class="form-control">
        <option selected>Choose...</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>
    <div class="form-group col-md-1">
      <label>Age</label>
      <input type="number" class="form-control" id=<?php echo "age".$x ?> name=<?php echo "age".$x ?>>
    </div>
  </div>
  <?php } ?>
  <small><?php echo $errors['name'] ?></small>
  <small><?php echo $errors['age'] ?></small>
  <small><?php echo $errors['gender'] ?></small><br>
  <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</form>
</div>
</div>