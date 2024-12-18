<?php
class ClassModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAvailableClasses() {
        $sql = "SELECT * FROM classes WHERE start_date > CURDATE() ORDER BY start_date ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function applyForClass($userId, $classId) {
        $sql = "INSERT INTO user_classes (user_id, class_id, status) VALUES (?, ?, 'Applied')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $classId]);
    }

    public function getUserAppliedClasses($userId) {
        $sql = "SELECT c.*, uc.status 
                FROM classes c 
                JOIN user_classes uc ON c.id = uc.class_id 
                WHERE uc.user_id = ? 
                ORDER BY c.start_date ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function cancelClassApplication($userId, $classId) {
        $sql = "DELETE FROM user_classes WHERE user_id = ? AND class_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $classId]);
    }

}

