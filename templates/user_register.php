<?php 
require_once "../configs/database_con.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $f_name = $_POST['f_name']; // First Name
    $l_name = $_POST['l_name']; // Last Name
    $gender = $_POST['gender']; // Gender
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];
    $dob = $_POST['dob']; // Date of Birth
    $house_no = $_POST['house_no']; // House Number
    $city = $_POST['city']; // City
    $street = $_POST['street']; // Street
    $phone_no = $_POST['phone_no']; // Phone Number

    // Validate that the passwords match
    if ($password !== $re_password) {
        echo "<alert>Password does not match</alert>";
    } else {
        // Check if the email is already registered
        $email_check_query = "SELECT Email FROM Registered_user WHERE Email = ?";
        $stmt_check = $conn->prepare($email_check_query);
        
        if ($stmt_check) {
            // Bind email parameter
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();

            // Check if the email exists
            if ($stmt_check->num_rows > 0) {
                echo "
                <script>
                    alert('Email already exists');
                    window.history.back(); // Optional: Redirect back to the previous page
                </script>";
            } else {
                $stmt_check->close(); // Close the check statement

                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Use parameterized query to insert user data
                $sql = "INSERT INTO Registered_user (F_name, L_name, Gender, User_password, DOB, House_no, City, Street, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Bind parameters
                    $stmt->bind_param("sssssisss", $f_name, $l_name, $gender, $hashed_password, $dob, $house_no, $city, $street, $email);
                    
                    // Execute the statement
                    if ($stmt->execute()) {
                        // Get the last inserted user ID
                        $user_id = $stmt->insert_id;

                        // Now insert the phone number
                        $phone_sql = "INSERT INTO Regiatered_user_phone_no (User_id, Phone_no) VALUES (?, ?)";
                        $phone_stmt = $conn->prepare($phone_sql);

                        if ($phone_stmt) {
                            $phone_stmt->bind_param("is", $user_id, $phone_no);
                            $phone_stmt->execute();
                            $phone_stmt->close();
                        }

                        echo "<script>
                                window.location.href = './login.php';
                            </script>";
                    } else {
                        echo '<div class="alert alert-danger text-center">Error: ' . $stmt->error . '</div>'; 
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo '<div class="alert alert-danger text-center">Error preparing statement: ' . $conn->error . '</div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger text-center">Error checking email: ' . $conn->error . '</div>';
        }
    }
}

// Close the database connection (optional)
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/registration_style.css">
    <title>Better Health</title>
    <!-- CSS FILES -->        
    <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/owl.carousel.min.css" rel="stylesheet">

        <link href="css/owl.theme.default.min.css" rel="stylesheet">

        <link href="css/templatemo-medic-care.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #register-form {
            margin-top: 100px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light shadow-lg">
                <div class="container">
                    <a class="navbar-brand mx-auto d-lg-none" href="index.html">
                        Better
                        <strong class="d-block">Health</strong>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="../index.html">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#about">About</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="./templates/product.php">Products</a>
                            </li>

                            <a class="navbar-brand d-none d-lg-block" href="index.html">
                                Better
                                <strong class="d-block">Health</strong>
                            </a>

                            <li class="nav-item">
                                <a class="nav-link" href="#reviews">Services</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#booking">FAQ</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Feedback</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
    <section id="register-form" class="d-flex justify-content-center">
        <div class="card" style="width: 800px;">
            <div class="card-body">
                <h5 class="card-title text-center">Register Now!</h5>
                <form method="POST">
                    <div class="form-group">
                        <label for="f_name">First Name:</label>
                        <input type="text" class="form-control" name="f_name" id="f_name" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="l_name">Last Name:</label>
                        <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Last Name" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" name="gender" id="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="re-password">Retype Password:</label>
                        <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Retype Password" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" name="dob" id="dob" required>
                    </div>
                    <div class="form-group">
                        <label for="house_no">House Number:</label>
                        <input type="text" class="form-control" name="house_no" id="house_no" placeholder="House Number" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" name="street" id="street" placeholder="Street" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_no">Phone Number:</label>
                        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone Number" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/formValidation.js"></script>
</body>
</html>
