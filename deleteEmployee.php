<?php
session_start();

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    if (!isset($_GET["employee_id"]) || empty(trim($_GET["employee_id"]))) {
        header("location: error.php");
        exit();
    }
    $_SESSION["employee_id"] = $_GET["employee_id"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["employee_id"]) && !empty($_SESSION["employee_id"])) {
        $employee_id = $_SESSION["employee_id"];

        $sql = "DELETE FROM fp_employee WHERE employee_id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_employee_id);
            $param_employee_id = $employee_id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: viewEmployee.php");
                exit();
            } else {
                echo "Error deleting the employee.";
            }

            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="employee_id" value="<?php echo ($_SESSION["employee_id"]); ?>"/>
                            <p>Are you sure you want to delete the record for Employee #<?php echo ($_SESSION["employee_id"]); ?>?</p><br>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="viewEmployee.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
