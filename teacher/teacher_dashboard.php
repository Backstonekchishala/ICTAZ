<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom styles for dashboard -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #28a745; /* Green color for sidebar */
            color: white;
            padding-top: 70px; /* Adjusted to keep content below the navbar */
            border-right: 5px solid white; /* White border separating sidebar and main content */
        }
        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: white;
        }
        .sidebar a:hover {
            background-color: #218838; /* Darker green on hover */
            color: white;
            text-decoration: none;
        }
        .main-content {
            margin-left: 250px; /* Adjusted to make space for the sidebar */
            padding: 20px;
        }
        .navbar {
            background-color: #28a745 !important; /* Green color for navbar */
            border-bottom: 2px solid white; /* White border separating navbar and main content */
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }
        .card {
            border-radius: 10px;
        }
        .card-header {
            background-color: #218838; /* Darker green for card headers */
            color: white;
            border-radius: 10px 10px 0 0; /* Rounded top corners */
        }
        .card-body {
            min-height: 200px; /* Example content height */
        }
        .card-title {
            font-size: 1.5rem;
        }
        .section-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .section-buttons a {
            margin: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-circle"></i> BC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-cogs"></i> Settings</a>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="card mb-4">
                <div class="card-header bg-success">
                    <h5 class="card-title">Teacher Dashboard</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Welcome to your dashboard. Here you can manage pupils, update results, and handle your classes.</p>
                    <div class="section-buttons">
                        <div class="section-buttons">
                            <a href="view_pupils_class.php" class="btn btn-primary"><i class="fas fa-eye"></i> View Pupils</a>
                            <a href="update_results.php" class="btn btn-info"><i class="fas fa-pencil-alt"></i> Update Results</a>
                            <a href="view_results.php" class="btn btn-warning"><i class="fas fa-list-alt"></i> View Results</a> <!-- New button -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
