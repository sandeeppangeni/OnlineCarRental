<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','carrental');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
//error_reporting(0);
if(isset($_POST['signup']))
{
$fname=$_POST['fullname'];
$email=$_POST['emailid']; 
$mobile=$_POST['mobileno'];
$address=$_POST['address'];
$password=md5($_POST['password']); 
$sql="INSERT INTO  tbldriver(FullName,EmailId,ContactNo,Password,Address) VALUES(:fname,:email,:mobile,:password,:address)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Registration successfull. Now you can login');</script>";
echo "<script type='text/javascript'> document.location = 'driverlogin.php'; </script>";

}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}

?>
<!doctype html>
<html lang="en" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Car Rental Portal | Driver Signup</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-social.css">
  <link rel="stylesheet" href="css/bootstrap-select.css">
  <link rel="stylesheet" href="css/fileinput.min.css">
  <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="css/style.css">
  <script>
    function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "check_availability.php",
    data:'emailid='+$("#emailid").val(),
    type: "POST",
    success:function(data){
    $("#user-availability-status").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
    }
    </script>
    <script type="text/javascript">
    function valid()
    {
    if(document.signup.password.value!= document.signup.confirmpassword.value)
    {
    alert("Password and Confirm Password Field do not match  !!");
    document.signup.confirmpassword.focus();
    return false;
    }
    return true;
}
</script>
</head>

<body>
  
  <div class="login-page bk-img" style="background: linear-gradient(to top right, #08aeea 0%, #b721ff 100%); position: relative; ">
    <div class="form-content" style="margin-top: -80px; position: relative;">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3" >
            <h1 class="text-center text-bold text-light mt-4x">Driver Sign Up</h1>
            <div class="well row pt-2x pb-3x bk-light">
              <div class="col-md-8 col-md-offset-2">
                <form method="post" name="signup"  onSubmit="return valid();">

                  <label for="" class="text-uppercase text-sm">Username </label>
                  <input type="text" placeholder="Full Name" pattern="[A-Za-z]+" name="fullname" class="form-control mb">

                  <label for="" class="text-uppercase text-sm">Email</label>
                  <input type="email" placeholder="Email" name="emailid"  pattern="[a-zA-Z0-9._]+@[a-zA-Z0-9._]+\.[a-zA-Z]{2,5}" class="form-control mb" id="emailid" onBlur="checkAvailability()">
                   <span id="user-availability-status" style="font-size:12px;"></span> 

                  <label for="" class="text-uppercase text-sm">Password</label>
                  <input type="password" placeholder="Password" pattern="[a-zA-Z0-9]{8,16}" name="password" class="form-control mb">

                  <label for="" class="text-uppercase text-sm">Confirm Password</label>
                  <input type="password" placeholder="Confirm Password" pattern="[a-zA-Z0-9]{8,16}" name="confirmpassword" class="form-control mb"> 

                  <label for="" class="text-uppercase text-sm">Address</label>
                  <input type="text" placeholder="Address" name="address" class="form-control mb">

                  <label for="" class="text-uppercase text-sm">Contact No.</label>
                  <input type="text" placeholder="Contact Number" name="mobileno" pattern="^\d{10}$" class="form-control mb">

                  <button class="btn btn-primary btn-block" type="submit" name="signup" type="submit">Register</button>
                  <br>  <br> 
                  
                  <p><h4>Already got an account? <a href="driverlogin.php">Login Here</a></h4></p>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Loading Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap-select.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <script src="js/fileinput.js"></script>
  <script src="js/chartData.js"></script>
  <script src="js/main.js"></script>

</body>

</html>