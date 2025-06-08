<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$customer_id = $c_name = $c_email = $c_address = $card_number = $sec_code = $exp_date = "";
$customer_id_err = $c_name_err = $c_email_err = $c_address_err = $card_number_err = $sec_code_err = $exp_date_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate ID
    $customer_id = trim($_POST["customer_id"]);
    if(empty($customer_id)){
        $customer_id_err = "Please enter a customer ID.";
    }
    // Validate c_name
    $c_name = trim($_POST["c_name"]);
    if(empty($c_name)){
        $c_name_err = "Please enter a customer name.";
    } elseif(!filter_var($c_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $c_name_err = "Please enter a valid customer name.";
    } 
 
    // Validate customer email
    $c_email = trim($_POST["c_email"]);
    if(empty($c_email)){
        $c_email_err = "Please enter a customer email.";     
    }
    
	// Validate c_address
    $c_address = trim($_POST["c_address"]);
    if(empty($c_address)){
        $c_address_err = "Please enter a customer address.";     
    }

       // Validate card_number
    $card_number = trim($_POST["card_number"]);
    if(empty($card_number)){
        $card_number_err = "Please enter a card number.";
    }
    // Validate sec_code
  	$sec_code = trim($_POST["sec_code"]);
    if(empty($sec_code)){
        $sec_code_err = "Please enter a sec code.";
    }
       // Validate exp_date
    $exp_date = trim($_POST["exp_date"]);
    if(empty($exp_date)){
        $exp_date_err = "Please enter an expiration date.";
    }

    // Check input errors before inserting in database
    if(empty($customer_id_err) && empty($c_name_err) && empty($c_email_err) && empty($c_address_err) && empty($card_number_err) && empty($sec_code_err)
				&& empty($exp_date_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO fp_customer (customer_id, c_name, c_email, c_address, card_number, sec_code, exp_date) 
		        VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssiis", $param_customer_id, $param_c_name, $param_c_email, $param_c_address, $param_card_number, $param_sec_code, 
				$param_exp_date);
            
            // Set parameters
			$param_customer_id = (int)$customer_id;
            $param_c_name = $c_name;
	    $param_c_email = $c_email;
	    $param_c_address = $c_address;
	    $param_card_number = (int)$card_number;
	    $param_sec_code = (int)$sec_code;
			$param_exp_date = $exp_date;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Customer created successfully. Redirect to landing page
				    header("location: viewCustomers.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new customer</h4></center>";
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
    <title>Create Customer</title>
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
                        <h2>Create Customer</h2>
                    </div>
                    <p>Please fill this form and submit to add a new customer to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($customer_id_err)) ? 'has-error' : ''; ?>">
                            <label>Customer ID</label>
                            <input type="text" name="customer_id" class="form-control" value="<?php echo $customer_id; ?>">
                            <span class="help-block"><?php echo $customer_id_err;?></span>
                        </div>
                 
						<div class="form-group <?php echo (!empty($c_name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="c_name" class="form-control" value="<?php echo $c_name; ?>">
                            <span class="help-block"><?php echo $c_name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($c_email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="c_email" class="form-control" value="<?php echo $c_email; ?>">
                            <span class="help-block"><?php echo $c_email_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($c_address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="c_address" class="form-control" value="<?php echo $c_address; ?>">
                            <span class="help-block"><?php echo $c_address_err;?></span>
			</div>
<div class="form-group <?php echo (!empty($card_number_err)) ? 'has-error' : ''; ?>">
                            <label>Card Number</label>
                            <input type="text" name="card_number" class="form-control" value="<?php echo $card_number; ?>">
                            <span class="help-block"><?php echo $card_number_err;?></span>
			</div>
<div class="form-group <?php echo (!empty($sec_code_err)) ? 'has-error' : ''; ?>">
                            <label>Sec Code</label>
                            <input type="text" name="sec_code" class="form-control" value="<?php echo $sec_code; ?>">
                            <span class="help-block"><?php echo $sec_code_err;?></span>
			</div>
<div class="form-group <?php echo (!empty($exp_date_err)) ? 'has-error' : ''; ?>">
                            <label>Expiration Date</label>
                            <input type="text" name="exp_date" class="form-control" value="<?php echo $exp_date; ?>">
                            <span class="help-block"><?php echo $exp_date_err;?></span>
                        </div>
		
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="viewCustomers.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
