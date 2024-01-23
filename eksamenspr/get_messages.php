<?php
require_once 'db.php';

// Get sort and search parameters from the URL
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build the SQL query based on parameters
$sql = "SELECT * FROM messages";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR message LIKE '%$search%'";
}

if ($sort === 'date') {
    $sql .= " ORDER BY date DESC";
} elseif ($sort === 'name') {
    $sql .= " ORDER BY name ASC";
} else {
    $sql .= " ORDER BY date DESC"; // Default sorting
}

$result = $conn->query($sql);

$messages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

echo json_encode($messages);

$conn->close();
?>
