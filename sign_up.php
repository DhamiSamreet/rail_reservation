<?php
// Include config file
//echo 'step1';

require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $credit_card_number=$address="";
$username_err = $password_err = $confirm_password_err = $credit_card_number_err = $address_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo 'step3';
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM booking_agent WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    echo 'all fine';
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty(trim($_POST["credit_card_number"]))){
        $credit_card_number_err = "Please enter a Credit Card Number.";     
    } else{
        $credit_card_number = trim($_POST["credit_card_number"]);
    }

    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter a Address";     
    } else{
        $address = trim($_POST["address"]);
    }
    //echo 'I am here $username';
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($credit_card_number_err) && empty($address_err)){
        
        // Prepare an insert statement
        echo 'main area';
        $sql = "INSERT INTO booking_agent (username, password,creditcard,address) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,"ssss", $param_username, $param_password,$param_creditcard,$param_address);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_address = $address;
            $param_creditcard=$credit_card_number;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo 'done';
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style type="text/css">
    .form-group{
        padding-left:35%;
        padding-right:35%;
        padding-top:-5%;
    }
    </style>
</head>
<?php //include('templates/header.php'); ?>
<div class="text-center">
<h1 alignment="center"> Sign Up </h1>
<form class="form_class" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="form-group">
    <label>Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
    <small id="emailHelp" class="form-text text-muted"><?php echo $username_err; ?></small>
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="password">
    <small id="emailHelp" class="form-text text-muted"><?php echo $password_err; ?></small>
  </div>
  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" class="form-control" name="confirm_password">
    <small id="emailHelp" class="form-text text-muted"><?php echo $confirm_password_err; ?></small>
  </div>
  <div class="form-group">
    <label>Credit Card Number</label>
    <input type="text" class="form-control" name="credit_card_number">
    <small id="emailHelp" class="form-text text-muted"><?php echo $credit_card_number_err; ?></small>
  </div>
  <div class="form-group">
    <label>Address</label>
    <input type="text" class="form-control" name="address">
    <small id="emailHelp" class="form-text text-muted"><?php echo $address_err; ?></small>
  </div>
  
    <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>
</form>
</body>