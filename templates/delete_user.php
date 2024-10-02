<?php
require_once "../configs/database_con.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    // Step 1: Delete products associated with orders
    $product_sql = "DELETE p FROM products p
                    JOIN orders o ON p.Order_id = o.Order_id
                    WHERE o.User_id = ?";
    $product_stmt = $conn->prepare($product_sql);
    if ($product_stmt) {
        $product_stmt->bind_param("i", $user_id);
        $product_stmt->execute();
        $product_stmt->close();
    }

    // Step 2: Delete orders associated with the user
    $order_sql = "DELETE FROM orders WHERE User_id = ?";
    $order_stmt = $conn->prepare($order_sql);
    if ($order_stmt) {
        $order_stmt->bind_param("i", $user_id);
        $order_stmt->execute();
        $order_stmt->close();
    }

    // Step 3: Delete prescriptions associated with the user
    $prescription_sql = "DELETE FROM prescription WHERE User_id = ?";
    $prescription_stmt = $conn->prepare($prescription_sql);
    if ($prescription_stmt) {
        $prescription_stmt->bind_param("i", $user_id);
        $prescription_stmt->execute();
        $prescription_stmt->close();
    }

    // Step 4: Delete phone numbers associated with the user
    $phone_sql = "DELETE FROM Regiatered_user_phone_no WHERE User_id = ?";
    $phone_stmt = $conn->prepare($phone_sql);
    if ($phone_stmt) {
        $phone_stmt->bind_param("i", $user_id);
        $phone_stmt->execute();
        $phone_stmt->close();
    }

    // Step 5: Finally, delete the user
    $user_sql = "DELETE FROM Registered_user WHERE User_id = ?";
    $user_stmt = $conn->prepare($user_sql);
    if ($user_stmt) {
        $user_stmt->bind_param("i", $user_id);
        $user_stmt->execute();
        $user_stmt->close();
    }

    // Redirect to the view_users page
    header("Location: view_users.php");
    exit();
}

// Close the database connection
$conn->close();
?>
