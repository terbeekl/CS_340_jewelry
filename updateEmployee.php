<?php
	session_start();	
// Include config file
	require_once "config.php";
 
// Define variables and initialize with empty values
// Note: You can not update SSN 
$salary = $e_name = "";
$salary_err = $e_name_err = "" ;
// Form default values

if(isset($_GET["employee_id"]) && !empty(trim($_GET["employee_id"]))){
	$_SESSION["employee_id"] = $_GET["employee_id"];

    // Prepare a select statement
    $sql1 = "SELECT * FROM fp_employee WHERE employee_id = ?";
  
    if($stmt1 = mysqli_prepare($link, $sql1)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt1, "i", $param_employee_id);      
        // Set parameters
       $param_employee_id = trim($_GET["employee_id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt1)){
            $result1 = mysqli_stmt_get_result($stmt1);
			if(mysqli_num_rows($result1) > 0){

				$row = mysqli_fetch_array($result1);

				$e_name = $row['e_name'];
				$salary = $row['salary'];
			}
		}
	}
}
 
// Post information about the employee when the form is submitted
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // the id is hidden and can not be changed
    $employee_id = $_SESSION["employee_id"];
    // Validate form data this is similar to the create Employee file
    // Validate name
    $e_name = trim($_POST["e_name"]);

    if(empty($e_name)){
        $e_name_err = "Please enter a name.";
    } elseif(!filter_var($e_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $e_name_err = "Please enter a valid name.";
    } 
 	
	// Validate Salary
    $salary = trim($_POST["salary"]);
    if(empty($salary)){
        $salary_err = "Please enter a salary.";    	
	}

    // Check input errors before inserting into database
    if(empty($e_name_err) && empty($salary_err)){
        // Prepare an update statement
        $sql = "UPDATE fp_employee SET e_name=?, salary = ? WHERE employee_id=?";
    
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sii", $param_e_name, $param_salary, $param_employee_id);
            
            // Set parameters
            $param_e_name = $e_name;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: viewEmployee.php");
                exit();
            } else{
                echo "<center><h2>Error when updating</center></h2>";
            }
        }        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else {

    // Check existence of sID parameter before processing further
	// Form default values

	if(isset($_GET["employee_id"]) && !empty(trim($_GET["employee_id"]))){
		$_SESSION["employee_id"] = $_GET["employee_id"];

		// Prepare a select statement
		$sql1 = "SELECT * FROM fp_employee WHERE employee_id = ?";
  
		if($stmt1 = mysqli_prepare($link, $sql1)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt1, "i", $param_employee_id);      
			// Set parameters
			$param_employee_id = trim($_GET["employee_id"]);

			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt1)){
				$result1 = mysqli_stmt_get_result($stmt1);
				if(mysqli_num_rows($result1) == 1){

					$row = mysqli_fetch_array($result1);

					$e_name = $row['e_name'];
					$salary = $row['salary'];
				} else{
					// URL doesn't contain valid id. Redirect to error page
					header("location: error.php");
					exit();
				}                
			} else{
				echo "Error in SSN while updating";
			}		
		}
			// Close statement
			mysqli_stmt_close($stmt1);
        
			// Close connection
			mysqli_close($link);
	}  else{
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
    <title>Company DB</title>
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
                        <h3>Update Record for Employee #<?php echo $_GET["employee_id"]; ?> </H3>
                    </div>
                    <p>Please edit the input values and submit to update.
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
						<div class="form-group <?php echo (!empty($e_name_err)) ? 'has-error' : ''; ?>">
                            <label>Employee Name</label>
                            <input type="text" name="e_name" class="form-control" value="<?php echo $e_name; ?>">
                            <span class="help-block"><?php echo $e_name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>	
                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
