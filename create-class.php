<?php
include 'config/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $duration = $_POST['duration'] ?? '';

    if (!empty($name) && !empty($start_date) && !empty($duration)) {
        try {
            global $pdo; 
            $query = "INSERT INTO classes (name, start_date, duration) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $start_date, PDO::PARAM_STR);
            $stmt->bindParam(3, $duration, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $success_message = "Class successfully created!";
            } else {
                $error_message = "Error creating class.";
            }
        } catch (Exception $e) {
            $error_message = "Exception occurred: " . $e->getMessage();
        }
    } else {
        $error_message = "All fields are required!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">Create a New Class</h1>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"> <?= htmlspecialchars($success_message) ?> </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"> <?= htmlspecialchars($error_message) ?> </div>
        <?php endif; ?>

        <div class="card shadow-sm p-4">
            <form action="create-class.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Class Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Duration:</label>
                    <input type="text" id="duration" name="duration" class="form-control" placeholder="e.g., 8 weeks" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Create Class</button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="instructor.php" class="btn btn-link">View All Classes</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
