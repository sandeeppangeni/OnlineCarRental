<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['dlogin'])==0)
  { 
header('location:driverlogin.php');
}
else{
  $error=[];
  if(isset($_POST['submit']))
  {
    if (isset($_POST['fullname'])&& !empty($_POST['fullname'])) 
          {
              $fullname = $_POST['fullname'];
          }
          else
          {
              $error[0] = "Name Must Be Provided";
          }
          if (isset($_POST['emailid'])&& !empty($_POST['emailid'])) 
          {
              $emailid = $_POST['emailid'];
          }
          else
          {
              $error[0] = "Email Must Be Provided";
          }
          if (isset($_POST['password'])&& !empty($_POST['password'])) {
              $password = md5($_POST['password']);
              
          }
          else
          {
              $error[0] = "Password Must Be Provided";
          }

          
           if (isset($_POST['contactno'])) {
              $contactno = $_POST['contactno'];
          }
          else
          {
              $error[0] = "Contact Number Must Be Provided";
          }
          if (isset($_POST['address'])) {
              $address = $_POST['address'];
          }
          else
          {
              $error[0] = "Address Must Be Provided";
          }
          $confirmpassword = md5($_POST['confirmpassword']);
            if ($password == $confirmpassword) {
                $password = md5($_POST['password']);
                $emailid=$_SESSION['dlogin'];
                 $sql="UPDATE tbldriver set Fullname=:fullname, EmailId =:Emailid, Password =:password ,ContactNo=:contactno,Address =:address WHERE EmailId='$emailid' " ;
              $query = $dbh->prepare($sql);
              $query->bindParam(':fullname',$fullname,PDO::PARAM_STR);
              $query->bindParam(':Emailid',$emailid,PDO::PARAM_STR);
              $query->bindParam(':password',$password,PDO::PARAM_STR);
              $query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
              $query->bindParam(':address',$address,PDO::PARAM_STR);
              $query->execute();

              
              $msg="Updated successfully";


              }
              else{
                echo "<script>alert('Password and Confirm Password doesnot match')</script>";
               
          }

         
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
  <meta name="theme-color" content="#3e454c">
  
  <title>Car Rental Portal | Driver Pannel  </title>

  <!-- Font awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Sandstone Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Bootstrap Datatables -->
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <!-- Bootstrap social button library -->
  <link rel="stylesheet" href="css/bootstrap-social.css">
  <!-- Bootstrap select -->
  <link rel="stylesheet" href="css/bootstrap-select.css">
  <!-- Bootstrap file input -->
  <link rel="stylesheet" href="css/fileinput.min.css">
  <!-- Awesome Bootstrap checkbox -->
  <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
  <!-- Admin Stye -->
  <link rel="stylesheet" href="css/style.css">
  <style>
    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
    </style>

</head>

<body>
  <?php include('includes/dheader.php');?>

  <div class="ts-main-content">
    <?php include('includes/dleftbar.php');?>
    <div class="content-wrapper">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12">

            <h2 class="page-title">Update Your Details</h2>

            <div class="panel panel-default">
              <div class="panel-heading">Update Your Details</div>
              <div class="panel-body">
              <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

              <?php 
              $emailid=$_SESSION['dlogin'];
              $sql = "SELECT * from  tbldriver where EmailId= '$emailid' ";
              $query = $dbh -> prepare($sql);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);
              $cnt=1;
              if($query->rowCount() > 0)
              {
              foreach($results as $result)
              {       ?>  
  
              
              <form method="POST" name="update" onSubmit="return valid();">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Fullname</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo htmlentities($result->Fullname);?>"  pattern="[A-Za-z]+" required ><br>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">EmailId</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="emailid" id="emailid" value="<?php echo htmlentities($result->EmailId);?>" pattern="[a-zA-Z0-9._]+@[a-zA-Z0-9._]+\.[a-zA-Z]{2,5}" required ><br>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Password</label>
                  <div class="col-sm-8">
                      <input type="password" class="form-control" name="password" id="password" pattern="[a-zA-Z0-9]{8,16}" required ><br>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Confirm Password</label>
                  <div class="col-sm-8">
                      <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" pattern="[a-zA-Z0-9]{8,16}" required ><br>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Mobile No</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="contactno" id="contactno" value="<?php echo htmlentities($result->ContactNo);?>" pattern="[9]{1}[6-8]{1}[0-9]{8}" required ><br><br>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Address</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="address" id="address" value="<?php echo htmlentities($result->Address);?>" required ><br><br>
                  </div>
                </div>


              <?php }} ?>
              
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-4">
                
                    <button class="btn btn-primary" name="submit" type="submit">Update Profile</button>
                  </div>
                </div>
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