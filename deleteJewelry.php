<?php
	session_start();
	if(isset($_GET["employee_id"]) && !empty(trim($_GET["employee_id"]))){
		$_SESSION["employee_id"] = $_GET["employee_id"];
		$employee_id = $_GET["employee_id"];
	}

    require_once "config.php";
	// Delete an employee's record after confirmation
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_SESSION["employee"]) && !empty($_SESSION["Ssn"])){ 
			$Essn = $_SESSION['Ssn'];
			$Dname = $_SESSION['Dname'];
			
			// Prepare a delete statement
			$sql = "DELETE FROM DEPENDENT WHERE Essn = ? 
						AND Dependent_name = ?";
   
			if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_Essn, $param_Dname);
 
				// Set parameters
				$param_Essn = $Essn;
				$param_Dname = $Dname;
				//echo $Essn;
				//echo $Dname;

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Records deleted successfully. Redirect to landing page
					header("location: index.php");
					exit();
				} else{
					echo "Error deleting the employee";
				}
			}
		}
		// Close statement
		mysqli_stmt_close($stmt);
    
		// Close connection
		mysqli_close($link);
	} else{
		// Check existence of id parameter
		if(empty(trim($_GET["Dname"]))){
			// URL doesn't contain id parameter. Redirect to error page
			header("location: error.php");
			exit();
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="Ssn" value="<?php echo ($_SESSION["Ssn"]); ?>"/>
                            <p>Are you sure you want to delete the record for Dependent of 
							     <?php echo ($_SESSION["Ssn"]); echo " ".$Dname; ?>?</p><br>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
