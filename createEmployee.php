<?php
/*
 * CS_340, Spring 2025
 * Group 6: Lydia TerBeek, Hailey Prater, Salem Demssie
 */

session_start();
$shop_address = $_SESSION["shop_address"];

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$employee_id = $salary = $e_name = "" ;
$employee_id_err = $salary_err =  $e_name_err = "" ;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Employee name
    $e_name = trim($_POST["e_name"]);
    if(empty($e_name)){
        $e_name_err = "Please enter an employee name.";
    } elseif(!filter_var($e_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $ename_err = "Please enter a valid name.";
    } 
 
	// Validate Salary
    $salary = trim($_POST["salary"]);
    if(empty($salary)){
        $salary_err = "Please enter salary.";     
    }
	// Validate Employee id
    $employee_id = trim($_POST["employee_id"]);
    if(empty($employee_id)){
        $employee_id_err = "Please enter employee id.";     
    }	

    // Check input errors before inserting in database
    if(empty($employee_id_err) && empty($salary_err) && empty($e_name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO fp_employee (shop_address, e_name, salary, employee_id) 
		        VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_shop_address, $param_e_name, $param_salary, 
									$param_employee_id);
           
            // Set parameters
			$param_shop_address = $shop_address;
			$param_e_name = $e_name;
			$param_salary = $salary;
			$param_employee_id = $employee_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
				    header("location: viewEmployee.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new employee</h4></center>";
				$Dname_err = "Re-enter all values";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Employee</title>
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
                        <h2>Create Employee</h2>
						<h3> For Location on <?php echo $shop_address; ?>: </h3>
                    </div>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
             
						<div class="form-group <?php echo (!empty($e_name_err)) ? 'has-error' : ''; ?>">
                            <label>Employee's Name</label>
                            <input type="text" name="e_name" class="form-control" value="<?php echo $e_name; ?>">
                            <span class="help-block"><?php echo $e_name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($employee_id_err)) ? 'has-error' : ''; ?>">
                            <label>Employee ID</label>
                            <input type="text" name="employee_id" class="form-control" value="<?php echo $employee_id; ?>">
                            <span class="help-block"><?php echo $employee_id_err;?></span>
                        </div>
				
						<div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="number" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
              
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="viewEmployee.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
