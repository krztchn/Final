<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Get user by email
    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $hashedPassword, $role = 'user') {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword, $role]);
    }
    
    public function createStudent($username, $email, $hashedPassword , $role = 'student') {

        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword, $role]);
    }

    public function createInstructor($username, $email, $hashedPassword , $role = 'instructor') {

        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword, $role]);
    }

    public function createAdmin($username, $email, $hashedPassword , $role = 'admin') {

        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword, $role]);
    }


    public function getByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data) {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, birthdate = ?, gender = ?, address = ?, hobby = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['birthdate'],
            $data['gender'],
            $data['address'],
            $data['hobby'],
            $userId
        ]);
    }

    public function calculateAge($birthdate) {
        $today = new DateTime();
        $birth = new DateTime($birthdate);
        $age = $today->diff($birth);
        return $age->y;
    }
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getStudents() {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE role = 'student'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
public function updateUser($id, $username, $email, $role) {
    $sql = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$username, $email, $role, $id]);
}

public function deleteUser($id) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
}

public function getById($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>
