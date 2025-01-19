<?php
// login.php
require_once 'config/db.php';
require 'functions/authenticate.php';
require 'functions/error.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "All fields are required";
    } else {
        if (loginUser($_POST['email'], $_POST['password'])) {
            header("Location: index.php?menu=dashboard");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
}
?>

<div class="container mt-5">
    <h2>Login</h2>
    <?php if ($error) echo displayError($error); ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="index.php?menu=register" class="btn btn-link">Don't have an account? Register</a>
    </form>
</div>