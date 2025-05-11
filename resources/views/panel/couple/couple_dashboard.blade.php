<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Couple Dashboard - Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .dashboard-container {
            padding: 20px;
        }
        .sidebar {
            background-color: #f0f0f0;
            padding: 20px;
            height: 100vh;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            margin-bottom: 10px;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
        }
        .sidebar a:hover {
            color: #007bff;
        }
        .content {
            padding: 20px;
        }
        .banner {
            background: url('{{ asset('images/banner_couple.jpg') }}');
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            min-height: 250px;
            background-size: cover;
        }
        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .profile-card h3 {
            margin-bottom: 10px;
        }
        .profile-card p {
            margin: 0;
        }
        .status-badge {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-completed {
            background-color: #28a745;
            color: #fff;
        }
        .status-pending {
            background-color: #ffc107;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
           <nav class="col-md-3 sidebar">
                <ul>
                    <li><a href="{{ route('couple.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('couple.profile.view') }}">Profile</a></li>
                    <li><a href="{{ route('couple.booking.details') }}">Booking Details</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="text-decoration: none; color: inherit;">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 content">
                <h2>Welcome, {{ $user->name }}!</h2>
                <div class="banner">
                </div>

                <div class="profile-card">
                    <h3>Profile Information</h3>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p>
                        <strong>Survey Status:</strong>
                        @if ($user->survey)
                            <span class="status-badge status-completed">Completed</span>
                        @else
                            <span class="status-badge status-pending">Pending</span>
                        @endif
                    </p>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
