<?php
// dashboard.php
require_once 'config/db.php';
require 'functions/authenticate.php';
require 'functions/error.php';
require 'functions/crud.php';

checkAuth();

$items = getItems($_SESSION['user_id']);
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['action']) {
        case 'create':
            if (createItem($_POST['title'], $_POST['description'], $_SESSION['user_id'])) {
                $_SESSION['success'] = "Item created successfully";
            }
            break;
            
        case 'delete':
            if (deleteItem($_POST['id'], $_SESSION['user_id'])) {
                $_SESSION['success'] = "Item deleted successfully";
            }
            break;
    }
    
    header("Location: index.php?menu=dashboard");
    exit();
}


?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <a href="index.php?menu=logout" class="btn btn-danger">Logout</a>
    </div>

    <?php if ($success) echo displaySuccess($success); ?>

    <!-- Create Item Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Add New Item</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <input type="hidden" name="action" value="create">
                <button type="submit" class="btn btn-primary">Add Item</button>
            </form>
        </div>
    </div>

    <!-- List Items -->
    <div class="card">
        <div class="card-header">
            <h4>Your Items</h4>
        </div>
        <div class="card-body">
            <?php if ($items): ?>
                <?php foreach ($items as $item): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                            <div class="btn-group">
                                <form action="" method="POST" class="me-2">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
