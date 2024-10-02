<?php
session_start();
require_once "../configs/database_con.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Check for admin credentials
    if ($email === 'admin123@gmail.com' && $password === 'admin1234') {
        header("Location: ./view_users.php");
        exit();
    }

    // Validate user credentials
    $sql = "SELECT * FROM registered_user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['User_password'])) {
            $_SESSION['username'] = $email;
            header("Location: user_product.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login</title>
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
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
            font-weight: bold;
        }
        .form-group label {
            color: #6c757d;
            font-size: 15px;
        }
        .form-control {
            border-radius: 25px;
            padding: 10px 15px;
            font-size: 16px;
        }
        .btn-block {
            border-radius: 25px;
            padding: 10px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-bottom: 20px;
            border-radius: 25px;
            text-align: center;
        }
        .register {
            margin-top: 15px;
        }
        .register a {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .register a:hover {
            text-decoration: underline;
            color: #0056b3;
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

<div class="container login-container">
    <div class="login-form">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Email</label>
                <input type="email" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="register">
                <a href="user_register.php">Don't have an account? Register here</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
