<?php
require_once "../configs/database_con.php";

// Fetch user data
$sql = "SELECT ru.User_id, ru.F_name, ru.L_name, ru.Gender, ru.DOB, ru.House_no, ru.City, ru.Street, ru.Email, GROUP_CONCAT(rp.Phone_no) AS Phone_numbers
        FROM Registered_user ru
        LEFT JOIN Regiatered_user_phone_no rp ON ru.User_id = rp.User_id
        GROUP BY ru.User_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/table_style.css">
    <title>User Data</title>

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
        .table-container {
            margin-top: 50px;
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

    <div class="container table-container">
        <h2 class="text-center">Registered Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>House No</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Email</th>
                    <th>Phone Numbers</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['User_id']; ?></td>
                            <td><?php echo $row['F_name']; ?></td>
                            <td><?php echo $row['L_name']; ?></td>
                            <td><?php echo $row['Gender']; ?></td>
                            <td><?php echo $row['DOB']; ?></td>
                            <td><?php echo $row['House_no']; ?></td>
                            <td><?php echo $row['City']; ?></td>
                            <td><?php echo $row['Street']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['Phone_numbers'] ? $row['Phone_numbers'] : 'N/A'; ?></td>
                            <td>
                                <a href="update_user.php?id=<?php echo $row['User_id']; ?>" class="btn btn-warning btn-sm ">Update</a>
                                <form action="delete_user.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $row['User_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">No registered users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
