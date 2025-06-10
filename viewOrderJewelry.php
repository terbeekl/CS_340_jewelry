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
    <title>View Order Jewelry</title>
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
                        <h2 class="pull-left">View Order Jewelry</h2>
                    </div>
<?php

// Check existence of id parameter before processing further
if(isset($_GET["order_number"]) && !empty(trim($_GET["order_number"]))){
	$_SESSION["order_number"] = $_GET["order_number"];
}

if(isset($_SESSION["order_number"]) ){
    // Prepare a select statement
    //$sql = "SELECT * FROM fp_order_jewelry WHERE order_number = ? ";
    $sql = "SELECT o.jewelry_id, j.type, j.price 
        FROM fp_order_jewelry o
        JOIN fp_jewelry j ON o.jewelry_id = j.jewelry_id 
        WHERE o.order_number = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_cid);      
        // Set parameters
       $param_cid = $_SESSION["order_number"];

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
			echo "<h4> Jewelry in Order #". $_SESSION["order_number"] ."</h4><p>";
			if(mysqli_num_rows($result) > 0){
				echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
				echo "<th>Jewelry ID</th>";
                echo "<th>Jewelry Type</th>";
                echo "<th>Price</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";							
				// output data of each row
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
			echo "<td>" . $row['jewelry_id'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>$" . $row['price'] . ".00</td>";
						//echo "<td>";
						  //echo "<a href='updateDependent.php?Dname=". $row['Dependent_name'] ."' title='Update Dependent' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                          //echo "<a href='deleteDependent.php?Dname=". $row['Dependent_name'] ."' title='Delete Dependent' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        //echo "</td>";
						echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";				
		    mysqli_free_result($result);
			
		    // Add Jewelry to Order form
echo "<h4>Add Jewelry to Order #" . $_SESSION["order_number"] . "</h4>";
echo '<form action="createOrderJewelry.php" method="post" class="form-inline">';
echo '    <input type="hidden" name="order_number" value="' . htmlspecialchars($_SESSION["order_number"]) . '">';
echo '    <div class="form-group">';
echo '        <label for="jewelry_id">Jewelry ID: </label>';
echo '        <input type="text" class="form-control" name="jewelry_id" id="jewelry_id" required>';
echo '    </div> ';
echo '    <button type="submit" class="btn btn-success">Add Jewelry</button>';
echo '</form><br>';



			} else {
				echo "No Jewelry In Order ";
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
	<p><a href="viewOrders.php" class="btn btn-primary">Back</a></p>
    </div>
   </div>        
  </div>
</div>
</body>
</html>
