<?php
session_start();
$customer_id = $_SESSION["customer_id"];

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$order_number = $date = $num_items = $cost = "" ;
$order_number_err = $date_err =  $num_items_err = $cost_err = "" ;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Order Number
    $order_number = trim($_POST["order_number"]);
    if(empty($order_number)){
        $order_number_err = "Please enter an order number.";
    } elseif(!filter_var($order_number, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{6}$/")))){
        $order_number_err = "Please enter a valid order_number.";
    } 
 
	// Validate Date
    $date = trim($_POST["date"]);
    if(empty($date)){
        $date_err = "Please enter the date.";     
    }
	// Validate Num Items
    $num_items = trim($_POST["num_items"]);
    if(empty($num_items)){
        $num_items_err = "Please enter the number of items in the order.";     
    }	

	// Validate Cost
    $cost = trim($_POST["cost"]);
    if(empty($cost)){
        $cost_err = "Please enter the cost.";
    }


    // Check input errors before inserting in database
    if(empty($order_number_err) && empty($date_err) && empty($num_items_err) && empty($cost_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO fp_order (customer_id, order_number, date, num_items, cost) 
		        VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisii", $param_customer_id, $param_order_number, $param_date, 
									$param_num_items, $param_cost);
           
            // Set parameters
			$param_customer_id = (int)$customer_id;
			$param_order_number = (int)$order_number;
			$param_date = $date;
			$param_num_items = (int)$num_items;
			$param_cost = (int)$cost;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
				    header("location: viewOrders.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new order</h4></center>";
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
    <title>Create Order</title>
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
                        <h2>Create Order</h2>
						<h3> For Customer #<?php echo $customer_id; ?>: </h3>
                    </div>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
             
						<div class="form-group <?php echo (!empty($order_number_err)) ? 'has-error' : ''; ?>">
                            <label>Order Number</label>
                            <input type="text" name="order_number" class="form-control" value="<?php echo $order_number; ?>">
                            <span class="help-block"><?php echo $order_number_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                            <label>Date Placed</label>
                            <input type="text" name="date" class="form-control" value="<?php echo $date; ?>">
                            <span class="help-block"><?php echo $date_err;?></span>
                        </div>
				
						<div class="form-group <?php echo (!empty($num_items_err)) ? 'has-error' : ''; ?>">
                            <label>Number of Items</label>
                            <input type="number" name="num_items" class="form-control" value="<?php echo $num_items; ?>">
                            <span class="help-block"><?php echo $num_items_err;?></span>
			</div>

			<div class="form-group <?php echo (!empty($cost_err)) ? 'has-error' : ''; ?>">
                            <label>Cost</label>
                            <input type="number" name="cost" class="form-control" value="<?php echo $cost; ?>">
                            <span class="help-block"><?php echo $cost_err;?></span>
                        </div> 
              
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="viewOrders.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
