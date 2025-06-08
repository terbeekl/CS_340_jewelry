<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_number = trim($_POST["order_number"]);
    $jewelry_id = trim($_POST["jewelry_id"]);

    // Basic validation
    if (!ctype_digit($order_number) || !ctype_digit($jewelry_id)) {
        echo "Invalid input.";
        exit();
    }

    // Insert into fp_order_jewelry
    $sql = "INSERT INTO fp_order_jewelry (order_number, jewelry_id) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $order_number, $jewelry_id);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the order detail page
            header("Location: viewOrderJewelry.php?order_id=" . $order_number);
            exit();
        } else {
            echo "Error: Could not add jewelry to order";
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>
