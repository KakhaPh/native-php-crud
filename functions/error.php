<?php 
require 'config/db.php';

function displayError($message) {
    return "<div class='alert alert-danger' role='alert'>$message</div>";
}

// Success message function
function displaySuccess($message) {
    return "<div class='alert alert-success' role='alert'>$message</div>";
}

?>