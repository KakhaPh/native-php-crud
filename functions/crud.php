<?php
require 'config/db.php';

// CRUD functions
function createItem($title, $description, $user_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO items (title, description, user_id) VALUES (?, ?, ?)");
        return $stmt->execute([$title, $description, $user_id]);
    } catch(PDOException $e) {
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