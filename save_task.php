<?php
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    $stmt = $conn->prepare("INSERT INTO tasks (task_name, subject, priority, difficulty, deadline) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data['taskName'], $data['taskSubject'], $data['taskPriority'], $data['taskDifficulty'], $data['taskDeadline']);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Task saved successfully"]);
    } else {
        echo json_encode(["error" => "Failed to save task"]);
    }
}
?>
