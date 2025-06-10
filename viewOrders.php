<?php
/*
 * CS_340, Spring 2025
 * Group 6: Lydia TerBeek, Hailey Prater, Salem Demssie
 */

	session_start();
    // Include config file
    require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
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
                        <h2 class="pull-left">View Orders</h2>
						<a href="createOrder.php" class="btn btn-success pull-right">Add Order</a>
                    </div>
<?php

// Check existence of id parameter before processing further
if(isset($_GET["customer_id"]) && !empty(trim($_GET["customer_id"]))){
	$_SESSION["customer_id"] = $_GET["customer_id"];
}
if(isset($_GET["c_name"]) && !empty(trim($_GET["c_name"]))){
	$_SESSION["c_name"] = $_GET["c_name"];
}

if(isset($_SESSION["customer_id"]) ){
    // Prepare a select statement
    $sql = "SELECT * FROM fp_order WHERE customer_id = ? ";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_cid);      
        // Set parameters
       $param_cid = $_SESSION["customer_id"];
       $cname = $_SESSION["c_name"];

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
			echo "<h4> Orders for ". $cname ."</h4><p>";
			if(mysqli_num_rows($result) > 0){
				echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
				echo "<th>Order Number</th>";
				echo "<th>Date Placed</th>";
				echo "<th>Number of Items</th>";
				echo "<th>Cost</th>";
				echo "<th>View Order Jewelry</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";							
				// output data of each row
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
			echo "<td>" . $row['order_number'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['num_items'] . "</td>";
			echo "<td>$" . $row['cost'] . ".00</td>";
						echo "<td>";
						  echo "<a href='viewOrderJewelry.php?order_number=". $row['order_number'] ."' title='View Order Jewelry' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                          //echo "<a href='deleteDependent.php?Dname=". $row['Dependent_name'] ."' title='Delete Dependent' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        echo "</td>";
						echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";				
				mysqli_free_result($result);
			} else {
				echo "No Orders. ";
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
	<p><a href="viewCustomers.php" class="btn btn-primary">Back</a></p>
    </div>
   </div>        
  </div>
</div>
</body>
</html>
