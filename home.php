<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentDress - Fashion at Your Fingertips</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> 
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #87CEFA;
            color: #333;
        }

        /* Navbar */
        nav {
            width: 100%;
            background-color: #4CAF50;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            padding: 10px 20px;
        }

        nav ul li a:hover {
            background-color: #45a049;
            border-radius: 5px;
        }

        /* Search bar in navbar */
        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 5px 10px;
            font-size: 1em;
            border: none;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        .search-bar button {
            padding: 5px 15px;
            font-size: 1em;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #45a049;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: url('https://www.w3schools.com/w3images/fashion.jpg') no-repeat center center/cover;
            height: 100vh;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);  /* Dark overlay */
            z-index: 1;
        }

        .hero h1, .hero p {
            position: relative;
            z-index: 2;  /* Ensure the text is above the overlay */
        }

        .cta-buttons a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 1.2em;
            margin: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .cta-buttons a:hover {
            background-color: #45a049;
        }

        /* Footer Section */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }

        /* Adjust for small screen */
        @media (max-width: 768px) {
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero h1 {
                font-size: 2.5em;
            }

            .hero p {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="ind.php">Browse Dresses</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
        <form class="search-bar" action="search.php" action="search.php" method="GET">
            <input type="text" name="q" placeholder="Search dresses..." required>
            <button type="submit">Search</button>
            
    </form>
        </form>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to RentDress</h1>
        <p>Your one-stop destination to rent the most stylish dresses for any occasion!</p>
        <div class="cta-buttons">
            <a href="signup.php">Sign Up</a>
            <a href="login.php">Login</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 RentDress | All Rights Reserved</p>
    </footer>

</body>
</html>
