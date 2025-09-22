<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'travel', 3306);

if ($db->connect_error) {
    die("Database Connection Failed: " . $db->connect_error);
}

// Handle Password Reset Request
if (isset($_POST['forgot_password'])) {
    $email = trim($_POST['email']);
    
    // Check if email exists
    $stmt = $db->prepare("SELECT fname, email FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32)); // Secure token
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour
        
        // Store token in database
        $stmt = $db->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();
        
        // Send reset email (in production, you would actually send an email)
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        $_SESSION['reset_token'] = $token; // For demo purposes we'll store in session
        
        echo "<script>alert('Password reset link has been sent to your email'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Email not found'); window.location.href='forgot_password.html';</script>";
    }
    exit();
}

// Handle Normal Login
if (isset($_POST['submit'])) {
    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);
    $d = date("Y-m-d h:i:sa");

    // Admin Login Check
    if ($username === 'admin' && $password === 'ad123') {
        $_SESSION['admin'] = true;
        $stmt = $db->prepare("INSERT INTO `login` (`user`, `pass`, `date_time`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $d);
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php');
        exit();
    }

    // User Login Check (Prevent SQL Injection)
    $stmt = $db->prepare("SELECT fname, email FROM `customer` WHERE fname = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['user'] = $username;
        $stmt->close();

        // Log the login attempt
        $stmt = $db->prepare("INSERT INTO `login` (`user`, `pass`, `date_time`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $d);
        $stmt->execute();
        $stmt->close();

        header("Location: mainPage.html");
        exit();
    } else {
        $stmt->close();
        echo "<script>alert('Invalid username or password'); window.location.href='login.html';</script>";
    }
}
?>