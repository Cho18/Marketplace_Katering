<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome CSS CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    

    <style>
        /* Main container styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width 0.3s;
            z-index: 1000;
            padding-top: 10px;
        }

        .sidebar.closed {
            width: 70px;
        }

        .sidebar .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transition: background 0.3s;
        }

        .sidebar .menu-item i {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .sidebar .menu-item:hover, 
        .sidebar .menu-item.active {
            background-color: #495057;
        }

        .sidebar .menu-item a {
            color: white;
            text-decoration: none; /* Remove underline */
            width: 100%; /* Make the link fill the menu item */
            display: block;
        }

        .sidebar.closed .menu-item {
            justify-content: center;
        }

        .sidebar.closed .menu-item i {
            margin-right: 0;
        }

        .sidebar.closed .menu-item span {
            display: none;
        }

        .sidebar h2 {
            padding: 10px 20px;
            text-align: left;
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar.closed h2 {
            display: none;
        }

        .sidebar .separator {
            border-bottom: 1px solid white;
            margin: 10px 20px;
        }

        .sidebar .toggle-button {
            padding: 20px;
            cursor: pointer;
            text-align: center;
            background-color: #007bff;
            border-radius: 10px 0 0 0;
            transition: background-color 0.3s;
        }

        .sidebar .toggle-button:hover {
            background-color: #0056b3;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        .navbar {
            background-color: #007bff;
            padding: 10px 20px;
            color: #fff;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: calc(100% - 250px);
            margin-left: 250px;
            transition: margin-left 0.3s, width 0.3s;
        }

        .main-content.collapsed ~ .navbar {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        .profile-link a {
            color: #fff;
            text-decoration: none;
        }

        .logout-button button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div>
            <h2>Marketplace Katering</h2>
    
            <div class="separator"></div>
    
            @if(Auth::user()->role_id == 2)
    <div class="menu-item {{ request()->is('merchant_profile') ? 'active' : '' }}">
        <i class="fa-solid fa-address-card"></i>
        <span><a href="/merchant_profile" class="text-white">Profile</a></span>
    </div>
        <div class="menu-item {{ request()->is('menu') ? 'active' : '' }}">
            <i class="fas fa-utensils"></i>
            <span><a href="/menu" class="text-white">Menu Makanan</a></span>
        </div>
        <div class="menu-item {{ request()->is('order') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
            <span><a href="/orders" class="text-white">Daftar Order</a></span>
        </div>
    @elseif(Auth::user()->role_id == 1)
        <div class="menu-item {{ request()->is('menu') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span><a href="/merchants" class="text-white">Katering</a></span>
        </div>
        <div class="menu-item {{ request()->is('menu') ? 'active' : '' }}">
            <i class="fas fa-utensils"></i>
            <span><a href="/menu" class="text-white">Menu Makanan</a></span>
        </div>
        <div class="menu-item {{ request()->is('profile') ? 'active' : '' }}">
            <i class="fa-solid fa-address-card"></i>
            <span><a href="/orders" class="text-white">Daftar Order</a></span>
        </div>
    @endif

        </div>
    
        <div class="toggle-button" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    

    <div class="navbar" id="navbar">
        <div class="logout-button">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>    

    <div class="main-content" id="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- JavaScript to toggle sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const navbar = document.getElementById('navbar');
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('collapsed');
            navbar.classList.toggle('collapsed');
        }
    </script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#menuTable').DataTable();
        });
    </script>

</body>
</html>
