<?php 
  session_start();
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
  }
  require_once "config.php";

  

  $tno = $_SESSION['trainno'];
  $trainname="";
  $doj = $_SESSION['date'];
  $pnr = $_SESSION['pnr'];
  $num_pass=$_SESSION['num_pass'];
  $created = "";
  $dtemp = strtotime($doj);
  $day  = date('j',$dtemp);
  $month= date('F',$dtemp);
  $year = date('Y',$dtemp);



  $sql1 = "SELECT name from trains where trainno = $tno;";
  if($res1 = mysqli_query($link,$sql1)){
    $trainname=  mysqli_fetch_all($res1,MYSQLI_ASSOC)[0]['name'];
    // print_r($traindetails);
    // $trainname=$traindetails[0]['name'];
  }
  
  
  $sql2 = "SELECT created from tickets where pnr = $pnr;";
  if($res2 = mysqli_query($link,$sql2)){
    $created = mysqli_fetch_all($res2,MYSQLI_ASSOC)[0]['created'];
  }


  $sql = "SELECT * FROM passengers where pnr=$pnr;";
  $passengers = "";
  if($res = mysqli_query($link,$sql)){
    $passengers = mysqli_fetch_all($res,MYSQLI_ASSOC);
    // foreach($passengers as $p){
    //   print_r($p);
    //   echo $p['gender'];
    // }
  }
  else{
    echo "query Error : ".mysqli_error($link);
  }

  //print_r($_SESSION);

?>





<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Oswald');
*
{
  margin: 0;
  padding: 0;
  border: 0;
  box-sizing: border-box
}

body
{
  background-color: #dadde6;
  font-family: arial
}

.fl-left{float: left}


.container
{
  width: 90%;
  margin: 100px auto
}

h1
{
  text-transform: uppercase;
  font-weight: 900;
  border-left: 10px solid #fec500;
  padding-left: 10px;
  margin-bottom: 30px
}

.row{overflow: hidden}

.card1
{
  display: table-row;
  width: 49%;
  background-color: #fff;
  color: #989898;
  margin-bottom: 10px;
  font-family: 'Oswald', sans-serif;
  text-transform: uppercase;
  border-radius: 4px;
  position: relative
}

.card + .card{margin-left: 2%}

.date
{
  display: table-cell;
  width: 25%;
  position: relative;
  text-align: center;
  border-right: 2px dashed #dadde6
}

.date:before,
.date:after
{
  content: "";
  display: block;
  width: 30px;
  height: 30px;
  background-color: #DADDE6;
  position: absolute;
  top: -15px ;
  right: -15px;
  z-index: 1;
  border-radius: 50%
}

.date:after
{
  top: auto;
  bottom: -15px
}

.date time
{
  display: block;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%)
}

.date time span{display: block}

.date time span:first-child
{
  color: #2b2b2b;
  font-weight: 600;
  font-size: 250%
}

.date time span:last-child
{
  text-transform: uppercase;
  font-weight: 600;
  margin-top: -10px
}

.card-cont
{
  display: table-cell;
  width: 75%;
  font-size: 85%;
  padding: 10px 10px 30px 50px
}

.card-cont h3
{
  color: #3C3C3C;
  font-size: 130%
}

.card-cont > div
{
  display: table-row
}

.card-cont .even-date i,
.card-cont .even-info i,
.card-cont .even-date time,
.card-cont .even-info p
{
  display: table-cell
}

.card-cont .even-date i,
.card-cont .even-info i
{
  padding: 5% 5% 0 0
}

.card-cont .even-info p
{
  padding: 30px 50px 0 0
}

.card-cont .even-date time span
{
  display: block
}

.card-cont a
{
  display: block;
  text-decoration: none;
  width: 80px;
  height: 30px;
  background-color: #D8DDE0;
  color: #fff;
  text-align: center;
  line-height: 30px;
  border-radius: 2px;
  position: absolute;
  right: 10px;
  bottom: 10px
}

.row:last-child .card:first-child .card-cont a
{
  background-color: #037FDD
}

.row:last-child .card:last-child .card-cont a
{
  background-color: #F8504C
}

@media screen and (max-width: 860px)
{
  .card
  {
    display: block;
    float: none;
    width: 100%;
    margin-bottom: 10px
  }
  
  .card + .card{margin-left: 0}
  
  .card-cont .even-date,
  .card-cont .even-info
  {
    font-size: 75%
  }
}
}
</style>
</head>
<body>

<section class="container">
<?php include('header.php'); ?>
<h1>Tickets</h1>
  <div>
    <article class="card1">
      <section class="date">
        <time datetime="doj">
          <span><?php echo "$day" ?></span><span> <?php echo "$month $year" ?> </span>
        </time>
      </section>
      <section class="card-cont">
        <small> <?php echo "train No. - $tno"; ?> </small>
        <h3> <?php echo "$trainname"; ?></h3>
        <div class="even-date">
         <i class="fa fa-calendar"></i>
         <time>
           <span> <?php echo "generated : $created " ?></span>
           <?php foreach ($passengers as $passenger){?>
            <span> <?php echo $passenger['name']."\t\t".$passenger['gender']."\t".$passenger['age']."\t".$passenger['coachno']."\t".$passenger['berthno']."\t".$passenger['berthtype']
             ?></span>
           <?php } ?>
         </time>
        </div>
        <div class="even-info">
          <i class="fa fa-map-marker"></i>
          <p>
            Always carry this ticket while travelling
          </p>
        </div>
        <a href="#">tickets</a>
      </section>
    </article>
  </div>
</div>
<div class="card text-center">
  <div class="card-header">
  <?php echo $tno."-".$trainname ?>
  </div>
  <div class="card-body">
    <h5 class="card-title">Journey Date: <?php echo "$day $month $year" ?></h5>
    <p class="card-text">Ticket Generated: <?php echo $created ?></p>
    <table class="table table-striped">
  <thead>
    <tr>
    <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Age</th>
      <th scope="col">Coach No.</th>
      <th scope="col">Berth No.</th>
      <th scope="col">Berth Type</th>
    </tr>
  </thead>
  <tbody>
  <?php $x=1;foreach ($passengers as $passenger){ ?>
    <tr>
      <th scope="row"><?php echo $x++ ?></th>
      <td><?php echo $passenger['name'] ?></td>
      <td><?php echo $passenger['gender'] ?></td>
      <td><?php echo $passenger['age'] ?></td>
      <td><?php echo $passenger['coachno'] ?></td>
      <td><?php echo $passenger['berthno'] ?></td>
      <td><?php echo $passenger['berthtype'] ?></td>
    </tr>
  <?php } ?>
    </tbody>
</table>
<a href="logout.php" class="btn btn-primary">Logout</a>
<a href="home.php" class="btn btn-primary">Book Another Ticket</a>
<a href="#" class="btn btn-primary">Print</a>
  </div>
  <div class="card-footer text-muted">
  Always carry this ticket while travelling
  </div>
</div>
<?php include('footer.php'); ?>
