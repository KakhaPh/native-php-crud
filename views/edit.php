<?php
require_once 'config/db.php';
require 'functions/authenticate.php';
require 'functions/error.php';
require 'functions/crud.php';

// edit.php
checkAuth();

$error = '';
$success = '';
$item = null;

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$item = getItems($_GET['id'], $_SESSION['user_id']);

if (!$item) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['title']) || empty($_POST['description'])) {
        $error = "All fields are required";
    } else {
        if (updateItem($_GET['id'], $_POST['title'], $_POST['description'], $_SESSION['user_id'])) {
            $_SESSION['success'] = "Item updated successfully";
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Update failed";
        }
    }
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Item</h2>
        <a href="index.php?menu=dashboard" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php
    if ($error) echo displayError($error);
    if ($success) echo displaySuccess($success);
    ?>

    <div class="card">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        value="<?php echo htmlspecialchars($item['title']); ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control"
                        id="description"
                        name="description"
                        required><?php echo htmlspecialchars($item['description']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Item</button>
            </form>
        </div>
    </div>
</div>