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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["jewelry_id"])) {
    $jewelry_id = $_SESSION["jewelry_id"];

    // Attempt deletion
    $delete_sql = "DELETE FROM fp_jewelry WHERE jewelry_id = ?";
    if ($stmt = mysqli_prepare($link, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, "i", $jewelry_id);

        // Execute and check for errors
        if (mysqli_stmt_execute($stmt)) {
            // Success: Redirect
            header("Location: index.php");
            exit();
        } else {
            // Failure: Display MySQL error (including trigger message)
            $error = mysqli_error($link);
            echo "Error: " . $error; // Shows "Cannot delete: Jewelry still in stock."
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($link);
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
