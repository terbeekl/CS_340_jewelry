<?php
/*
 * CS_340, Spring 2025
 * Group 6: Lydia TerBeek, Hailey Prater, Salem Demssie
 */

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$jewelry_id = $type = $primary_material = $price = "";
$jewelry_id_err = $type_err = $primary_material_err = $price_err = "" ;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate type
    $type = trim($_POST["type"]);
    if(empty($type)){
        $type_err = "Please enter a jewelry type.";
    } elseif(!filter_var($type, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $type_err = "Please enter a valid jewelry type.";
    } 
    // Validate primary_material
    $primary_material = trim($_POST["primary_material"]);
    if(empty($primary_material)){
        $primary_material_err = "Please enter a primary material.";
    } elseif(!filter_var($primary_material, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $primary_material_err = "Please enter a valid primary material.";
    } 
 
    // Validate jewelry_id
    $jewelry_id = trim($_POST["jewelry_id"]);
    if(empty($jewelry_id)){
        $jewelry_id_err = "Please enter a jewelry ID.";     
    } elseif(!ctype_digit($jewelry_id)){
        $jewelry_id_err = "Please enter a positive integer jewelry ID.";
    } 
    
	// Validate price
    $price = trim($_POST["price"]);
    if(empty($price)){
        $price_err = "Please enter a monetary value.";     
    }

    // Check input errors before inserting in database
    if(empty($jewelry_id_err) && empty($price_err) && empty($type_err) 
				&& empty($primary_material_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO fp_jewelry (jewelry_id, type, primary_material, price) 
		        VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issi", $param_jewelry_id, $param_type, $param_primary_material, 
				$param_price);
            
            // Set parameters
			$param_jewelry_id = (int)$jewelry_id;
            $param_primary_material = $primary_material;
			$param_type = $type;
			$param_price = (int)$price;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Jewelry created successfully. Redirect to landing page
				    header("location: index.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new jewelry</h4></center>";
				$jewelry_id_err = "Enter a unique jewelry ID.";
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
    <title>Create Jewelry</title>
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
                        <h2>Create Jewelry</h2>
                    </div>
                    <p>Please fill this form and submit to add a new piece of jewelry to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($jewelry_id_err)) ? 'has-error' : ''; ?>">
                            <label>Jewelry ID</label>
                            <input type="text" name="jewelry_id" class="form-control" value="<?php echo $jewelry_id; ?>">
                            <span class="help-block"><?php echo $jewelry_id_err;?></span>
                        </div>
                 
						<div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" value="<?php echo $type; ?>">
                            <span class="help-block"><?php echo $type_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($primary_material_err)) ? 'has-error' : ''; ?>">
                            <label>Primary Material</label>
                            <input type="text" name="primary_material" class="form-control" value="<?php echo $primary_material; ?>">
                            <span class="help-block"><?php echo $primary_material_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
		
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
