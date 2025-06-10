<?php
/*
 * CS_340, Spring 2025
 * Group 6: Lydia TerBeek, Hailey Prater, Salem Demssie
 */

	session_start();
	//$currentpage="View Employees"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company DB</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
	<style type="text/css">
        .wrapper{
            width: 70%;
            margin:0 auto;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
		 $('.selectpicker').selectpicker();
    </script>
</head>
<body>
    <?php
        // Include config file
        require_once "config.php";
//		include "header.php";
	?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12"> 
		    <div class="page-header clearfix">
                <div class="page-header text-center">
                    <img src="https://media.istockphoto.com/id/990529836/vector/diamond-cartoon-vector-and-illustration.jpg?s=612x612&w=0&k=20&c=rnshYB7JCT7wxTwzC1RY5nqU4LrFWB6CJMXQ6X5d_N4="  
                        style="height: 70px">
                    <h2> Jewelry Shop Database </h2> 
                    <p>Hailey, Lydia, and Salem's Jewelry Store	
                </div>
                <nav class ="text-center">
                    <a href="viewShops.php">View Shops</a> | 
                    <a href="viewCustomers.php">View Customers</a>
                    </br>
                    </br>
                </nav>
            
                    			
		       <h2 class="pull-left">Jewelry</h2>
               <a href="createJewelry.php" class="btn btn-success pull-right">Add Jewelry</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select all employee query execution
					// *****
					// Insert your function for Salary Level
					/*
						$sql = "SELECT Ssn,Fname,Lname,Salary, Address, Bdate, PayLevel(Ssn) as Level, Super_ssn, Dno
							FROM EMPLOYEE";
					*/
                    $sql = "SELECT jewelry_id, type, primary_material, price
							FROM fp_jewelry";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
			    	echo "<tr>";
			    		echo "<th width=20%>Jewelry ID</th>";
			    		echo "<th width=30%>Jewelry Type</th>";
                                        echo "<th width=20%>Primary Material</th>";
                                        echo "<th width=15%>Price</th>";
                                        echo "<th width=15%>Edit</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
					echo "<tr>";
					echo "<td>" . $row['jewelry_id'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['primary_material'] . "</td>";
                        echo "<td>$" . $row['price'] . ".00</td>";
                        echo "<td>";
                        echo "<a href='updateJewelry.php?jewelry_id=". $row['jewelry_id'] ."' title='Update Jewelry' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                        echo "<a href='deleteJewelry.php?jewelry_id=". $row['jewelry_id'] ."' title='Delete Jewelry' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";  
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
					
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>

</body>
</html>
