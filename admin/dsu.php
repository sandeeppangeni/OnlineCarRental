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
	if (isset($_POST['longitude'])&& !empty($_POST['longitude'])) 
        {
            $longitude = $_POST['longitude'];
        }
        else
        {
            $error[0] = "Longitude Must Be Provided";
        }
        if (isset($_POST['latitude'])&& !empty($_POST['latitude'])) {
            $latitude = $_POST['latitude'];
        }
        else
        {
            $error[0] = "Latitude Must Be Provided";
        }
        
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        }
        else
        {
            $error[0] = "Status Must Be Provided";
        }
        
        $emailid=$_SESSION['dlogin'];

        $sql="UPDATE tbldriverstatus set Latitude =:latitude, Longitude=:longitude,Status=:status where EmailId='$emailid' ";
		$query = $dbh->prepare($sql);
		
		$query->bindParam(':latitude',$latitude,PDO::PARAM_STR);
		$query->bindParam(':longitude',$longitude,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);
		$query->execute();
		
		$msg="Updated successfully";
	
		
	}

}
 ?>

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

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Update Your Details</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
				<?php
					$emailid=$_SESSION['dlogin'];
					$sql = "SELECT * from  tbldriverstatus where EmailId='$emailid' ";
					$query = $dbh -> prepare($sql);
					$query->execute();
					$results=$query->fetchAll(PDO::FETCH_OBJ);
					$cnt=1;
					if($query->rowCount() > 0)
					{
					foreach($results as $result)
					{				?>
								
							<form method="POST">

								<div class="form-group">
									<label class="col-sm-4 control-label">Latitude</label>
									<div class="col-sm-8">
											<input type="text" class="form-control" name="latitude" id="latitude" pattern="^([-+]?\d{1,2}[.]\d+)" value="<?php echo htmlentities($result->Latitude);?>" required ><br>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Longitude</label>
									<div class="col-sm-8">
											<input type="text" class="form-control" name="longitude" id="longitude"  value="<?php echo htmlentities($result->Longitude);?>" required ><br>
									</div>
								</div>

								

								<div class="form-group">
									<label class="col-sm-4 control-label">Status</label>
									<div class="col-sm-8">
						
											<select name="status"  class="selectpicker">
										
									        	<option value="0">Driving</option>
									        	<option value="1">Leisure</option>
									      	</select>

											<br><br>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-4">
								
										<button class="btn btn-primary" name="submit" type="submit">Update</button>
									</div>
								</div>
							<?php } ?>
								
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
<?php } ?>