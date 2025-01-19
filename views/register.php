<?php
// register.php
require_once 'config/db.php';
require 'functions/authenticate.php';
require 'functions/error.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = "All fields are required";
    } else {
        if (registerUser($_POST['username'], $_POST['email'], $_POST['password'])) {
            $success = "Registration successful! Please login.";
        } else {
            $error = "Registration failed. Email might be already taken.";
        }
    }
}
?>
<div class="container mt-5">
    <h2>Register</h2>
    <?php
    if ($error) echo displayError($error);
    if ($success) echo displaySuccess($success);
    ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="index.php?menu=login" class="btn btn-link">Already have an account? Login</a>
    </form>
</div>