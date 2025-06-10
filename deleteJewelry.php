<?php
/*
 * CS_340, Spring 2025
 * Group 6: Lydia TerBeek, Hailey Prater, Salem Demssie
 */

session_start();

if (isset($_GET["jewelry_id"]) && !empty(trim($_GET["jewelry_id"]))) {
    $_SESSION["jewelry_id"] = $_GET["jewelry_id"];
    $jewelry_id = $_GET["jewelry_id"];
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["jewelry_id"]) && !empty($_SESSION["jewelry_id"])) {
        $jewelry_id = $_SESSION["jewelry_id"];

        $check_sql = "SELECT num_items FROM fp_stock WHERE jewelry_id = ?";
        if ($check_stmt = mysqli_prepare($link, $check_sql)) {
            mysqli_stmt_bind_param($check_stmt, "i", $jewelry_id);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_bind_result($check_stmt, $num_items);

            mysqli_stmt_close($check_stmt);
        }

        $delete_order_sql = "DELETE FROM fp_order_jewelry WHERE jewelry_id = ?";
        if ($stmt_order = mysqli_prepare($link, $delete_order_sql)) {
            mysqli_stmt_bind_param($stmt_order, "i", $jewelry_id);
            mysqli_stmt_execute($stmt_order);
            mysqli_stmt_close($stmt_order);
        }

        $delete_jewelry_sql = "DELETE FROM fp_jewelry WHERE jewelry_id = ?";
        if ($stmt = mysqli_prepare($link, $delete_jewelry_sql)) {
            mysqli_stmt_bind_param($stmt, "i", $jewelry_id);

            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "Cannot delete: jewelry still in stock.";
            }

            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }
} else {
    if (empty(trim($_GET["jewelry_id"]))) {
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Jewelry</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>.wrapper { width: 500px; margin: 0 auto; }</style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Delete Jewelry</h1>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="jewelry_id" value="<?php echo htmlspecialchars($_SESSION["jewelry_id"]); ?>"/>
                        <p>Are you sure you want to delete Jewelry ID #<?php echo htmlspecialchars($_SESSION["jewelry_id"]); ?>?</p><br>
                        <input type="submit" value="Yes" class="btn btn-danger">
                        <a href="index.php" class="btn btn-default">No</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
