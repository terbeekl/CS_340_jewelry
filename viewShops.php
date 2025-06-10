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
    <title>Shop Addresses</title>
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
                        <h2 class="pull-left">Shop Addresses</h2>
                    </div>
<?php

// Check existence of id parameter before processing further
// if(isset($_GET["Ssn"]) && !empty(trim($_GET["Ssn"]))){
// 	$_SESSION["Ssn"] = $_GET["Ssn"];
// }
// if(isset($_GET["Lname"]) && !empty(trim($_GET["Lname"]))){
// 	$_SESSION["Lname"] = $_GET["Lname"];
// }

//if(isset($_SESSION["Ssn"]) ){
	
	
    // Prepare a select statement
    $sql = "SELECT shop_address
			FROM fp_shop";
            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th width=70%>Shop Address</th>";
                                echo "<th width=70%>Additional Shop Info</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['shop_address'] . "</td>";
                                echo "<td>";
                echo "<a href='viewEmployee.php?shop_address=". $row['shop_address']."' title='View Employees' data-toggle='tooltip'><span class='glyphicon glyphicon-user'></span></a>";
				echo "<a href='viewStock.php?shop_address=". $row['shop_address']."' title='View Stock' data-toggle='tooltip'><span class='glyphicon glyphicon-pushpin'></span></a>";
				echo "<a href='viewVisitRecords.php?shop_address=". $row['shop_address']."' title='View Customer Vist History' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
				echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";                            
                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                } else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
            } else{
                echo "ERROR: Could not able to execute $sql. <br>" . mysqli_error($link);
            }    
    echo "<p><a href='index.php' class='btn btn-primary'>Back</a></p>"; 
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
// } else{
//     // URL doesn't contain id parameter. Redirect to error page
//     header("location: error.php");
//     exit();
// }
    
?>					                 					
	
    </div>
   </div>        
  </div>
</div>
</body>
</html>
