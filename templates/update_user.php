<?php
require_once "../configs/database_con.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user data
    $user_id = $_POST['user_id'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $house_no = $_POST['house_no'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];

    // Debugging: Check the city value
    error_log("City value: " . $city); // Log the city value to check

    $sql = "UPDATE Registered_user SET F_name = ?, L_name = ?, Gender = ?, DOB = ?, House_no = ?, City = ?, Street = ?, Email = ? WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssssss", $f_name, $l_name, $gender, $dob, $house_no, $city, $street, $email, $user_id);
        if (!$stmt->execute()) {
            error_log("Update error: " . $stmt->error); // Log any execution errors
        }
        $stmt->close();
    }

    // Update phone number
    $phone_sql = "DELETE FROM Regiatered_user_phone_no WHERE User_id = ?";
    $phone_stmt = $conn->prepare($phone_sql);
    if ($phone_stmt) {
        $phone_stmt->bind_param("i", $user_id);
        $phone_stmt->execute();
        $phone_stmt->close();
    }

    // Insert the new phone number
    $insert_phone_sql = "INSERT INTO Regiatered_user_phone_no (User_id, Phone_no) VALUES (?, ?)";
    $insert_phone_stmt = $conn->prepare($insert_phone_sql);
    if ($insert_phone_stmt) {
        $insert_phone_stmt->bind_param("is", $user_id, $phone_no);
        $insert_phone_stmt->execute();
        $insert_phone_stmt->close();
    }

    // Redirect to the view_users page
    header("Location: view_users.php");
    exit();
}

// Fetch existing user data for the form
$user_id = $_GET['id'];
$user_query = "SELECT * FROM Registered_user WHERE User_id = ?";
$stmt = $conn->prepare($user_query);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

// Fetch phone numbers
$phone_query = "SELECT Phone_no FROM Regiatered_user_phone_no WHERE User_id = ?";
$phone_stmt = $conn->prepare($phone_query);
if ($phone_stmt) {
    $phone_stmt->bind_param("i", $user_id);
    $phone_stmt->execute();
    $phone_result = $phone_stmt->get_result();
    $phone_numbers = [];
    while ($phone_row = $phone_result->fetch_assoc()) {
        $phone_numbers[] = $phone_row['Phone_no'];
    }
    $phone_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Update User</title>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Update User</h2>
        <form method="POST" action="update_user.php">
            <input type="hidden" name="user_id" value="<?php echo $user['User_id']; ?>">
            <div class="form-group">
                <label for="f_name">First Name:</label>
                <input type="text" class="form-control" name="f_name" id="f_name" value="<?php echo $user['F_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="l_name">Last Name:</label>
                <input type="text" class="form-control" name="l_name" id="l_name" value="<?php echo $user['L_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value="Male" <?php echo $user['Gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $user['Gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo $user['Gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $user['DOB']; ?>" required>
            </div>
            <div class="form-group">
                <label for="house_no">House Number:</label>
                <input type="text" class="form-control" name="house_no" id="house_no" value="<?php echo $user['House_no']; ?>" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" name="city" id="city" value="<?php echo $user['City']; ?>" required>
            </div>
            <div class="form-group">
                <label for="street">Street:</label>
                <input type="text" class="form-control" name="street" id="street" value="<?php echo $user['Street']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo $user['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_no">Phone Number:</label>
                <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo implode(", ", $phone_numbers); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update User</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
