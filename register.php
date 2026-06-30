<?php
session_start();

include "db.php";

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $national_id_number = trim($_POST['national_id_number']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $driving_license_number = trim($_POST['driving_license_number']);
    $gender = trim($_POST['gender']);
    $preferred_car_type = trim($_POST['preferred_car_type']);
    $password = $_POST['password'];

    // Basic validation
    if ($fullname === '' || $national_id_number === '' || $email === '' || $phone === '' || 
        $driving_license_number === '' || $gender === '' || $preferred_car_type === '' || $password === '') {
        $error_message = 'All fields are required.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users 
            (fullname, national_id_number, email, phone, driving_license_number, gender, preferred_car_type, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            $error_message = 'Database error: ' . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssss", 
                $fullname, $national_id_number, $email, $phone, 
                $driving_license_number, $gender, $preferred_car_type, $hashed_password
            );

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success_message'] = 'Registration successful. Please log in.';
                mysqli_stmt_close($stmt);
                header('Location: login.php');
                exit;
            } else {
                $error_message = 'Registration failed: ' . mysqli_error($conn);
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>User Registration</h2>



    <form method="POST" action="register.php">
        Full Name:<br>
        <input type="text" name="fullname" required><br><br>

        National ID Number:<br>
        <input type="text" name="national_id_number" required><br><br>

        Email:<br>
        <input type="email" name="email" required><br><br>

        Phone Number:<br>
        <input type="text" name="phone" required><br><br>

        Driving License Number:<br>
        <input type="text" name="driving_license_number" required><br><br>

        Gender:<br>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>

        Preferred Car Type:<br>
        <input type="text" name="preferred_car_type" required><br><br>

        Password:<br>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="register" value="Register">
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
