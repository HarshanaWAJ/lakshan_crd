<?php 
require_once "../configs/database_con.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re-password']; // Capture re-entered password

    // Validate that the passwords match
    if ($password !== $re_password) {
        // Use SweetAlert2 to show an error message for password mismatch
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Password Does not Match!',
                text: 'Please re-enter your password.',
                confirmButtonText: 'OK'
            });
        </script>";
    } else {
        // Check if the email is already registered
        $email_check_query = "SELECT email FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($email_check_query);
        
        if ($stmt_check) {
            // Bind email parameter
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();

            // Check if the email exists
            if ($stmt_check->num_rows > 0) {
                // Use SweetAlert2 to exist email
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Already Registered!',
                        text: 'The email you entered is already associated with an account.',
                        confirmButtonText: 'OK'
                    });
                </script>";
            } else {
                // Proceed to insert the new user data
                $stmt_check->close(); // Close the check statement

                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Use parameterized query to prevent SQL injection
                $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Bind parameters
                    $stmt->bind_param("sss", $name, $email, $password); // Use hashed_password
                    // Execute the statement
                    if ($stmt->execute()) {
                        // Use SweetAlert2 after registration
                        echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Registration Successful!',
                                text: 'You have been registered successfully.',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'user_register.php'; // Redirect after confirmation
                                }
                            });
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
    <title>Better Health</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }
        #register-form {
            margin-top: 100px; /* Space from the top */
        }
    </style>
</head>
<body>
    <section id="register-form" class="d-flex justify-content-center">
        <div class="card" style="width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">Register Now!</h5>
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
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
