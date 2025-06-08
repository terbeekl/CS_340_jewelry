<?php
session_start();
require_once "config.php";

$type = $primary_material = $price = "";
$type_err = $primary_material_err = $price_err = "";

if (isset($_GET["jewelry_id"]) && !empty(trim($_GET["jewelry_id"]))) {
    $_SESSION["jewelry_id"] = $_GET["jewelry_id"];
    $jewelry_id = $_SESSION["jewelry_id"];

    $sql = "SELECT * FROM fp_jewelry WHERE jewelry_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $jewelry_id;

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $type = $row['type'];
                $primary_material = $row['primary_material'];
                $price = $row['price'];
            } else {
                header("location: error.php");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jewelry_id = $_SESSION["jewelry_id"];

    $type = trim($_POST["type"]);
    if (empty($type)) {
        $type_err = "Please enter a type.";
    }

    $primary_material = trim($_POST["primary_material"]);
    if (empty($primary_material)) {
        $primary_material_err = "Please enter a material.";
    }

    $price = trim($_POST["price"]);
    if (!is_numeric($price)) {
        $price_err = "Please enter a valid price.";
    }

    if (empty($type_err) && empty($primary_material_err) && empty($price_err)) {
        $sql = "UPDATE fp_jewelry SET type=?, primary_material=?, price=? WHERE jewelry_id=?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssii", $param_type, $param_material, $param_price, $param_id);

            $param_type = $type;
            $param_material = $primary_material;
            $param_price = $price;
            $param_id = $jewelry_id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "<h2>Error updating jewelry.</h2>";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Jewelry</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .wrapper { width: 500px; margin: 0 auto; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Update Jewelry ID #<?php echo htmlspecialchars($_SESSION["jewelry_id"]); ?></h2>
    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
            <label>Type</label>
            <input type="text" name="type" class="form-control" value="<?php echo $type; ?>">
            <span class="help-block"><?php echo $type_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($primary_material_err)) ? 'has-error' : ''; ?>">
            <label>Primary Material</label>
            <input type="text" name="primary_material" class="form-control" value="<?php echo $primary_material; ?>">
            <span class="help-block"><?php echo $primary_material_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
            <label>Price</label>
            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
            <span class="help-block"><?php echo $price_err; ?></span>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
        <a href="index.php" class="btn btn-default">Cancel</a>
    </form>
</div>
</body>
</html>

