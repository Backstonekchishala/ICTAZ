<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom styles for dashboard -->
    <style>
        body {
            background-color: #f8f9fa;
            margin-bottom: 60px; /* Adjusted to make space for the fixed footer */
        }
        .login-container {
            margin-top: 100px;
        }
        .card {
            border-radius: 10px;
            width: 100%;
        }
        .card-header {
            background-color: #28a745; /* Green color */
            color: white;
            border-radius: 10px 10px 0 0; /* top-left, top-right, bottom-right, bottom-left */
        }
        .btn-primary {
            background-color: #28a745; /* Green color */
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .navbar {
            background-color: #28a745; /* Green color */
        }
        .navbar-brand {
            color: white;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #28a745; /* Green color */
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .footer p {
            margin: 0; /* Remove default margin to ensure centered text */
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Chalimbana Secondary Pupil Management System</span>
        </div>
    </nav>
<!-- <h3>Current Staff and Parents</h3> -->
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="email">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted mb-0">Chalimbana Secondary Pupil Management System &copy; 2024</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
