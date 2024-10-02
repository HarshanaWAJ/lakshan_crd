<?php
require_once "../configs/database_con.php";

// Fetch products
$sql = "SELECT name, price, quantity, description, exp_date FROM products";
$result = $conn->query($sql);

// Start HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/owl.carousel.min.css" rel="stylesheet">

        <link href="css/owl.theme.default.min.css" rel="stylesheet">

        <link href="css/templatemo-medic-care.css" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            margin: 15px;
            transition: transform 0.2s;
            border: 1px solid #007bff;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            color: #007bff;
        }
        .card-text {
            color: #555;
        }
        h1 {
            color: #343a40;
        }
        .container {
            margin-top: 10px;
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


    <div class="container">
        <h1 class="text-center my-4">Medicines Available</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p class="card-text"><strong>Price:</strong> $' . number_format($row['price'], 2) . '</p>';
                    echo '<p class="card-text"><strong>Quantity:</strong> ' . htmlspecialchars($row['quantity']) . '</p>';
                    echo '<p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="card-text"><strong>Expiry Date:</strong> ' . htmlspecialchars($row['exp_date']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No products found.</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
