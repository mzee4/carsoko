<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Soko Rental</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Car Soko Rental Services</h1>
    <p>Your Trusted Car Rental Partner</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
</nav>

<div class="container">

    <div class="hero">
        <h2>Rent Your Dream Car Today</h2>
        <p>
            Affordable, reliable, and comfortable vehicles
            available for business trips, vacations, and daily use.
        </p>
    </div>

    <h2>Our Services</h2>

    <div class="services">

        <div class="card">
            <h3>Economy Cars</h3>
            <p>Affordable cars for daily transportation.</p>
        </div>

        <div class="card">
            <h3>Luxury Cars</h3>
            <p>Premium vehicles for special occasions.</p>
        </div>

        <div class="card">
            <h3>SUV Rentals</h3>
            <p>Spacious vehicles for family trips.</p>
        </div>

    </div>

    <br>

    <h2>Why Choose Us?</h2>

    <ul>
        <li>Affordable rental rates</li>
        <li>24/7 customer support</li>
        <li>Wide range of vehicles</li>
        <li>Easy online booking</li>
        <li>Professional service</li>
    </ul>

</div>

<footer>
    &copy; 2026 CarSoko Rental Services
</footer>

</body>
</html>