<?php

class ClassModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ... other methods ...

    public function cancelClassApplication($userId, $classId) {
        $sql = "DELETE FROM user_classes WHERE user_id = ? AND class_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $classId]);
    }

    // ... other methods ...
}

?>

