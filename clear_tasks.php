<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "DELETE FROM tasks";
    if (mysqli_query($conn, $query)) {
        echo "All tasks deleted!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
