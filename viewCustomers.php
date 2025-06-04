<?php
	session_start();
    // Include config file
    require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Customers</title>
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
                        <h2 class="pull-left">View Customers</h2>
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
    $sql = "SELECT c_name, c_email, customer_id
			FROM fp_customer";
            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th width=10%>Customer Name</th>";
                                echo "<th width=10%>Customer Email</th>";
                                echo "<th width=10%>Customer ID</th>";
                                echo "<th width=10%>View Orders</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['c_name'] . "</td>";
                                echo "<td>" . $row['c_email'] . "</td>";
                                echo "<td>" . $row['customer_id'] . "</td>";
                                echo "<td>";
                                    echo "<a href='viewOrders.php?Ssn=". $row['Ssn']."&Lname=".$row['Lname']."' title='View Projects' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
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