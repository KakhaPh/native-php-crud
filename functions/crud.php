<?php
require 'config/db.php';

// CRUD functions
function createItem($title, $description, $user_id, $image) {
    global $pdo;

    try {
        $targetDir = "storage/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = uniqid() . "_" . basename($image['name']);
        $targetFile = $targetDir . $fileName;

        if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
            throw new Exception("Failed to upload image.");
        }

        $stmt = $pdo->prepare("INSERT INTO items (title, description, user_id, image_path) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $user_id, $targetFile]);
    } catch (Exception $e) {
        error_log("Create item error: " . $e->getMessage());
        return false;
    }
}

function getItems($user_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Get items error: " . $e->getMessage());
        return [];
    }
}

function updateItem($id, $title, $description, $user_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE items SET title = ?, description = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$title, $description, $id, $user_id]);
    } catch(PDOException $e) {
        error_log("Update item error: " . $e->getMessage());
        return false;
    }
}

function deleteItem($id, $user_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $user_id]);
    } catch(PDOException $e) {
        error_log("Delete item error: " . $e->getMessage());
        return false;
    }
}




?>