<?php
	session_start();
    // Include config file
    require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Employees</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
	   <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <nav>
                            </br>
                            <a href="index.php">Home</a> | 
                            <a href="viewShops.php">View Shops</a> | 
                            <a href="viewCustomers.php">View Customers</a>
                            </br>
                            </br>
                        </nav>
                        <h2 class="pull-left">View Employees</h2>
						<a href="createEmployee.php" class="btn btn-success pull-right">Add Employee</a>
                    </div>
<?php

// Check existence of id parameter before processing further
if(isset($_GET["shop_address"]) && !empty(trim($_GET["shop_address"]))){
	$_SESSION["shop_address"] = $_GET["shop_address"];
}

if(isset($_SESSION["shop_address"]) ){
	
    // Prepare a select statement
    $sql = "SELECT * FROM fp_employee WHERE shop_address = ? ";
  
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_addy);      
        // Set parameters
       $param_addy = $_SESSION["shop_address"];

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
			echo "<h4> Employees for ". $param_addy ."</h4><p>";
			if(mysqli_num_rows($result) > 0){
				echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Employee Name</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";							
				// output data of each row
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>" . $row['e_name'] . "</td>";
						echo "<td>";
						  //echo "<a href='updateDependent.php?Dname=". $row['Dependent_name'] ."' title='Update Dependent' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                          //echo "<a href='deleteDependent.php?Dname=". $row['Dependent_name'] ."' title='Delete Dependent' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        echo "</td>";
						echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";				
				mysqli_free_result($result);
			} else {
				echo "No Employees. ";
			}
//				mysqli_free_result($result);
        } else{
			// URL doesn't contain valid id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>					                 					
	<p><a href="viewShops.php" class="btn btn-primary">Back</a></p>
    </div>
   </div>        
  </div>
</div>
</body>
</html>