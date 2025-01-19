<?php include 'includes/header.php'; ?>

<div class="container">
    <?php
    $route = $_GET['menu'] ?? '';

    switch ($route) {
        case '404':
            include 'views/404.php';
            break;
        case 'dashboard':
            include 'views/dashboard.php';
            break;
        case 'login':
            include 'views/login.php';
            break;
        case 'logout':
            include 'views/logout.php';
            break;
        case 'register':
            include 'views/register.php';
            break;
        case 'edit':
            include 'views/edit.php';
            break;
        default:
            include 'views/index.php';
            break;
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>